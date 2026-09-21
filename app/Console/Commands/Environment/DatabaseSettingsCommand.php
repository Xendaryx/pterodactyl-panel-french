<?php

namespace Pterodactyl\Console\Commands\Environment;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\DatabaseManager;
use Pterodactyl\Traits\Commands\EnvironmentWriterTrait;

class DatabaseSettingsCommand extends Command
{
    use EnvironmentWriterTrait;

    protected $description = 'Configure les paramètres de la base de données du Panel.';

    protected $signature = 'p:environment:database
                            {--host= : L’adresse de connexion au serveur MySQL.}
                            {--port= : Le port de connexion au serveur MySQL.}
                            {--database= : La base de données à utiliser.}
                            {--username= : Le nom d’utilisateur à utiliser pour la connexion.}
                            {--password= : Le mot de passe à utiliser pour cette base de données.}';

    protected array $variables = [];

    /**
     * DatabaseSettingsCommand constructor.
     */
    public function __construct(private DatabaseManager $database, private Kernel $console)
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
        $this->output->note('Il est fortement recommandé de ne pas utiliser "localhost" comme hôte de base de données en raison de problèmes fréquents de connexion par socket. Pour une connexion locale, utilisez "127.0.0.1".');
        $this->variables['DB_HOST'] = $this->option('host') ?? $this->ask(
            'Hôte de la base de données',
            config('database.connections.mysql.host', '127.0.0.1')
        );

        $this->variables['DB_PORT'] = $this->option('port') ?? $this->ask(
            'Port de la base de données',
            config('database.connections.mysql.port', 3306)
        );

        $this->variables['DB_DATABASE'] = $this->option('database') ?? $this->ask(
            'Nom de la base de données',
            config('database.connections.mysql.database', 'panel')
        );

        $this->output->note('L’utilisation du compte "root" pour les connexions MySQL est fortement déconseillée et n’est pas autorisée par cette application. Vous devez créer un utilisateur MySQL dédié à ce logiciel.');
        $this->variables['DB_USERNAME'] = $this->option('username') ?? $this->ask(
            'Nom d’utilisateur de la base de données',
            config('database.connections.mysql.username', 'pterodactyl')
        );

        $askForMySQLPassword = true;
        if (!empty(config('database.connections.mysql.password')) && $this->input->isInteractive()) {
            $this->variables['DB_PASSWORD'] = config('database.connections.mysql.password');
            $askForMySQLPassword = $this->confirm('Un mot de passe de connexion MySQL semble déjà être défini. Souhaitez-vous le modifier ?');
        }

        if ($askForMySQLPassword) {
            $this->variables['DB_PASSWORD'] = $this->option('password') ?? $this->secret('Mot de passe de la base de données');
        }

        try {
            $this->testMySQLConnection();
        } catch (\PDOException $exception) {
            $this->output->error(sprintf('Impossible de se connecter au serveur MySQL avec les identifiants fournis. L’erreur retournée est : "%s".', $exception->getMessage()));
            $this->output->error('Vos identifiants de connexion n’ont PAS été enregistrés. Vous devez fournir des informations de connexion valides avant de continuer.');

            if ($this->confirm('Revenir en arrière et réessayer ?')) {
                $this->database->disconnect('_pterodactyl_command_test');

                return $this->handle();
            }

            return 1;
        }

        $this->writeToEnvironment($this->variables);

        $this->info($this->console->output());

        return 0;
    }

    /**
     * Test that we can connect to the provided MySQL instance and perform a selection.
     */
    private function testMySQLConnection()
    {
        config()->set('database.connections._pterodactyl_command_test', [
            'driver' => 'mysql',
            'host' => $this->variables['DB_HOST'],
            'port' => $this->variables['DB_PORT'],
            'database' => $this->variables['DB_DATABASE'],
            'username' => $this->variables['DB_USERNAME'],
            'password' => $this->variables['DB_PASSWORD'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'strict' => true,
        ]);

        $this->database->connection('_pterodactyl_command_test')->getPdo();
    }
}
