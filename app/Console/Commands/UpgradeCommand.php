<?php

namespace Pterodactyl\Console\Commands;

use Illuminate\Console\Command;
use Pterodactyl\Console\Kernel;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Helper\ProgressBar;

class UpgradeCommand extends Command
{
    protected const DEFAULT_URL = 'https://github.com/pterodactyl/panel/releases/%s/panel.tar.gz';

    protected $signature = 'p:upgrade
        {--user= : L’utilisateur sous lequel PHP s’exécute. Tous les fichiers appartiendront à cet utilisateur.}
        {--group= : Le groupe sous lequel PHP s’exécute. Tous les fichiers appartiendront à ce groupe.}
        {--url= : L’archive spécifique à télécharger.}
        {--release= : Une version spécifique de Pterodactyl à télécharger depuis GitHub. Laissez vide pour utiliser la dernière version.}
        {--skip-download : Si cette option est définie, aucune archive ne sera téléchargée.}';

    protected $description = 'Télécharge une nouvelle archive de Pterodactyl depuis GitHub, puis exécute les commandes normales de mise à niveau.';

    /**
     * Executes an upgrade command which will run through all of our standard
     * commands for Pterodactyl and enable users to basically just download
     * the archive and execute this and be done.
     *
     * This places the application in maintenance mode as well while the commands
     * are being executed.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $skipDownload = $this->option('skip-download');
        if (!$skipDownload) {
            $this->output->warning('Cette commande ne vérifie pas l’intégrité des fichiers téléchargés. Assurez-vous de faire confiance à la source du téléchargement avant de continuer. Si vous ne souhaitez pas télécharger d’archive, utilisez l’option --skip-download ou répondez "non" à la question ci-dessous.');
            $this->output->comment('Source du téléchargement (définie avec --url=) :');
            $this->line($this->getUrl());
        }

        if (version_compare(PHP_VERSION, '8.2.0', '<')) {
            $this->error('Impossible d’exécuter le processus de mise à niveau automatique. La version minimale requise de PHP est 8.2.0, votre version est [' . PHP_VERSION . '].');
        }

        $user = 'www-data';
        $group = 'www-data';
        if ($this->input->isInteractive()) {
            if (!$skipDownload) {
                $skipDownload = !$this->confirm('Souhaitez-vous télécharger et extraire les fichiers de l’archive de la dernière version ?', true);
            }

            if (is_null($this->option('user'))) {
                $userDetails = posix_getpwuid(fileowner('public'));
                $user = $userDetails['name'] ?? 'www-data';

                if (!$this->confirm("L’utilisateur de votre serveur web a été détecté comme <fg=blue>[{$user}]:</> est-ce correct ?", true)) {
                    $user = $this->anticipate(
                        'Saisissez le nom de l’utilisateur exécutant le processus de votre serveur web. Celui-ci varie selon le système, mais il s’agit généralement de "www-data", "nginx" ou "apache".',
                        [
                            'www-data',
                            'nginx',
                            'apache',
                        ]
                    );
                }
            }

            if (is_null($this->option('group'))) {
                $groupDetails = posix_getgrgid(filegroup('public'));
                $group = $groupDetails['name'] ?? 'www-data';

                if (!$this->confirm("Le groupe de votre serveur web a été détecté comme <fg=blue>[{$group}]:</> est-ce correct ?", true)) {
                    $group = $this->anticipate(
                        'Saisissez le nom du groupe exécutant le processus de votre serveur web. Il s’agit normalement du même nom que votre utilisateur.',
                        [
                            'www-data',
                            'nginx',
                            'apache',
                        ]
                    );
                }
            }

            if (!$this->confirm('Êtes-vous sûr de vouloir lancer le processus de mise à niveau de votre Panel ?')) {
                $this->warn('Processus de mise à niveau interrompu par l’utilisateur.');

                return;
            }
        }

        ini_set('output_buffering', '0');
        $bar = $this->output->createProgressBar($skipDownload ? 9 : 10);
        $bar->start();

        if (!$skipDownload) {
            $this->withProgress($bar, function () {
                $this->line("\$upgrader> curl -L \"{$this->getUrl()}\" | tar -xzv");
                $process = Process::fromShellCommandline("curl -L \"{$this->getUrl()}\" | tar -xzv");
                $process->run(function ($type, $buffer) {
                    $this->{$type === Process::ERR ? 'error' : 'line'}($buffer);
                });
            });
        }

        $this->withProgress($bar, function () {
            $this->line('$upgrader> php artisan down');
            $this->call('down');
        });

        $this->withProgress($bar, function () {
            $this->line('$upgrader> chmod -R 755 storage bootstrap/cache');
            $process = new Process(['chmod', '-R', '755', 'storage', 'bootstrap/cache']);
            $process->run(function ($type, $buffer) {
                $this->{$type === Process::ERR ? 'error' : 'line'}($buffer);
            });
        });

        $this->withProgress($bar, function () {
            $command = ['composer', 'install', '--no-ansi'];
            if (config('app.env') === 'production' && !config('app.debug')) {
                $command[] = '--optimize-autoloader';
                $command[] = '--no-dev';
            }

            $this->line('$upgrader> ' . implode(' ', $command));
            $process = new Process($command);
            $process->setTimeout(10 * 60);
            $process->run(function ($type, $buffer) {
                $this->line($buffer);
            });
        });

        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__ . '/../../../bootstrap/app.php';
        /** @var Kernel $kernel */
        $kernel = $app->make(Kernel::class);
        $kernel->bootstrap();
        $this->setLaravel($app);

        $this->withProgress($bar, function () {
            $this->line('$upgrader> php artisan view:clear');
            $this->call('view:clear');
        });

        $this->withProgress($bar, function () {
            $this->line('$upgrader> php artisan config:clear');
            $this->call('config:clear');
        });

        $this->withProgress($bar, function () {
            $this->line('$upgrader> php artisan migrate --force --seed');
            $this->call('migrate', ['--force' => true, '--seed' => true]);
        });

        $this->withProgress($bar, function () use ($user, $group) {
            $this->line("\$upgrader> chown -R {$user}:{$group} *");
            $process = Process::fromShellCommandline("chown -R {$user}:{$group} *", $this->getLaravel()->basePath());
            $process->setTimeout(10 * 60);
            $process->run(function ($type, $buffer) {
                $this->{$type === Process::ERR ? 'error' : 'line'}($buffer);
            });
        });

        $this->withProgress($bar, function () {
            $this->line('$upgrader> php artisan queue:restart');
            $this->call('queue:restart');
        });

        $this->withProgress($bar, function () {
            $this->line('$upgrader> php artisan up');
            $this->call('up');
        });

        $this->newLine(2);
        $this->info('Le Panel a été mis à niveau avec succès. Assurez-vous également de mettre à jour toutes les instances Wings : https://pterodactyl.io/wings/1.0/upgrading.html');
    }

    protected function withProgress(ProgressBar $bar, \Closure $callback)
    {
        $bar->clear();
        $callback();
        $bar->advance();
        $bar->display();
    }

    protected function getUrl(): string
    {
        if ($this->option('url')) {
            return $this->option('url');
        }

        return sprintf(self::DEFAULT_URL, $this->option('release') ? 'download/v' . $this->option('release') : 'latest/download');
    }
}
