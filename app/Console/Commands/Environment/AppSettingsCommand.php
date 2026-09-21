<?php

namespace Pterodactyl\Console\Commands\Environment;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Pterodactyl\Traits\Commands\EnvironmentWriterTrait;

class AppSettingsCommand extends Command
{
    use EnvironmentWriterTrait;

    public const CACHE_DRIVERS = [
        'redis' => 'Redis (recommandé)',
        'memcached' => 'Memcached',
        'file' => 'Système de fichiers',
    ];

    public const SESSION_DRIVERS = [
        'redis' => 'Redis (recommandé)',
        'memcached' => 'Memcached',
        'database' => 'Base de données MySQL',
        'file' => 'Système de fichiers',
        'cookie' => 'Cookie',
    ];

    public const QUEUE_DRIVERS = [
        'redis' => 'Redis (recommandé)',
        'database' => 'Base de données MySQL',
        'sync' => 'Synchrone',
    ];

    protected $description = 'Configure les paramètres d’environnement de base du Panel.';

    protected $signature = 'p:environment:setup
                            {--new-salt : Indique s’il faut générer un nouveau sel pour Hashids.}
                            {--author= : L’adresse e-mail à laquelle les services créés sur cette instance doivent être associés.}
                            {--url= : L’URL sur laquelle ce Panel est accessible.}
                            {--timezone= : Le fuseau horaire à utiliser pour les heures du Panel.}
                            {--cache= : Le pilote de cache à utiliser.}
                            {--session= : Le pilote de session à utiliser.}
                            {--queue= : Le pilote de file d’attente à utiliser.}
                            {--redis-host= : L’hôte Redis à utiliser pour les connexions.}
                            {--redis-pass= : Le mot de passe utilisé pour se connecter à Redis.}
                            {--redis-port= : Le port utilisé pour se connecter à Redis.}
                            {--settings-ui= : Active ou désactive l’interface de configuration.}
                            {--telemetry= : Active ou désactive la télémétrie anonyme.}';

    protected array $variables = [];

    /**
     * AppSettingsCommand constructor.
     */
    public function __construct(private Kernel $console)
    {
        parent::__construct();
    }

    /**
     * Handle command execution.
     *
     * @throws \Pterodactyl\Exceptions\PterodactylException
     */
    public function handle(): int
    {
        if (empty(config('hashids.salt')) || $this->option('new-salt')) {
            $this->variables['HASHIDS_SALT'] = str_random(20);
        }

        $this->output->comment('Indiquez l’adresse e-mail à utiliser comme auteur des Eggs exportés par ce Panel. Il doit s’agir d’une adresse e-mail valide.');
        $this->variables['APP_SERVICE_AUTHOR'] = $this->option('author') ?? $this->ask(
            'Adresse e-mail de l’auteur des Eggs',
            config('pterodactyl.service.author', 'unknown@unknown.com')
        );

        if (!filter_var($this->variables['APP_SERVICE_AUTHOR'], FILTER_VALIDATE_EMAIL)) {
            $this->output->error('L’adresse e-mail fournie pour l’auteur du service est invalide.');

            return 1;
        }

        $this->output->comment('L’URL de l’application DOIT commencer par https:// ou http:// selon que vous utilisez SSL ou non. Si vous n’indiquez pas le protocole, les liens présents dans vos e-mails et autres contenus pointeront vers un emplacement incorrect.');
        $this->variables['APP_URL'] = $this->option('url') ?? $this->ask(
            'URL de l’application',
            config('app.url', 'https://example.com')
        );

        $this->output->comment('Le fuseau horaire doit correspondre à l’un de ceux pris en charge par PHP. En cas de doute, consultez https://php.net/manual/en/timezones.php.');
        $this->variables['APP_TIMEZONE'] = $this->option('timezone') ?? $this->anticipate(
            'Fuseau horaire de l’application',
            \DateTimeZone::listIdentifiers(),
            config('app.timezone')
        );

        $selected = config('cache.default', 'redis');
        $this->variables['CACHE_DRIVER'] = $this->option('cache') ?? $this->choice(
            'Pilote de cache',
            self::CACHE_DRIVERS,
            array_key_exists($selected, self::CACHE_DRIVERS) ? $selected : null
        );

        $selected = config('session.driver', 'redis');
        $this->variables['SESSION_DRIVER'] = $this->option('session') ?? $this->choice(
            'Pilote de session',
            self::SESSION_DRIVERS,
            array_key_exists($selected, self::SESSION_DRIVERS) ? $selected : null
        );

        $selected = config('queue.default', 'redis');
        $this->variables['QUEUE_CONNECTION'] = $this->option('queue') ?? $this->choice(
            'Pilote de file d’attente',
            self::QUEUE_DRIVERS,
            array_key_exists($selected, self::QUEUE_DRIVERS) ? $selected : null
        );

        if (!is_null($this->option('settings-ui'))) {
            $this->variables['APP_ENVIRONMENT_ONLY'] = $this->option('settings-ui') == 'true' ? 'false' : 'true';
        } else {
            $this->variables['APP_ENVIRONMENT_ONLY'] = $this->confirm('Activer l’éditeur de paramètres dans l’interface ?', true) ? 'false' : 'true';
        }

        $this->output->comment('Consultez https://pterodactyl.io/panel/1.0/additional_configuration.html#telemetry pour obtenir davantage d’informations sur les données de télémétrie et leur collecte.');
        $this->variables['PTERODACTYL_TELEMETRY_ENABLED'] = $this->option('telemetry') ?? $this->confirm(
            'Autoriser l’envoi de données de télémétrie anonymes ?',
            config('pterodactyl.telemetry.enabled', true)
        ) ? 'true' : 'false';

        // Make sure session cookies are set as "secure" when using HTTPS
        if (str_starts_with($this->variables['APP_URL'], 'https://')) {
            $this->variables['SESSION_SECURE_COOKIE'] = 'true';
        }

        $this->checkForRedis();
        $this->writeToEnvironment($this->variables);

        $this->info($this->console->output());

        return 0;
    }

    /**
     * Check if redis is selected, if so, request connection details and verify them.
     */
    private function checkForRedis()
    {
        $items = collect($this->variables)->filter(function ($item) {
            return $item === 'redis';
        });

        // Redis was not selected, no need to continue.
        if (count($items) === 0) {
            return;
        }

        $this->output->note('Vous avez sélectionné le pilote Redis pour une ou plusieurs options. Indiquez ci-dessous des informations de connexion valides. Dans la plupart des cas, vous pouvez conserver les valeurs par défaut sauf si vous avez modifié votre configuration.');
        $this->variables['REDIS_HOST'] = $this->option('redis-host') ?? $this->ask(
            'Hôte Redis',
            config('database.redis.default.host')
        );

        $askForRedisPassword = true;
        if (!empty(config('database.redis.default.password'))) {
            $this->variables['REDIS_PASSWORD'] = config('database.redis.default.password');
            $askForRedisPassword = $this->confirm('Un mot de passe semble déjà être défini pour Redis. Souhaitez-vous le modifier ?');
        }

        if ($askForRedisPassword) {
            $this->output->comment('Par défaut, une instance Redis locale ne possède pas de mot de passe car elle est inaccessible depuis l’extérieur. Si c’est votre cas, appuyez simplement sur Entrée sans saisir de valeur.');
            $this->variables['REDIS_PASSWORD'] = $this->option('redis-pass') ?? $this->output->askHidden(
                'Mot de passe Redis'
            );
        }

        if (empty($this->variables['REDIS_PASSWORD'])) {
            $this->variables['REDIS_PASSWORD'] = 'null';
        }

        $this->variables['REDIS_PORT'] = $this->option('redis-port') ?? $this->ask(
            'Port Redis',
            config('database.redis.default.port')
        );
    }
}
