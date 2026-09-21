<?php

namespace Pterodactyl\Console\Commands;

use Illuminate\Console\Command;
use Pterodactyl\Services\Helpers\SoftwareVersionService;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class InfoCommand extends Command
{
    protected $description = 'Affiche les configurations de l’application, de la base de données et des e-mails ainsi que la version du Panel.';

    protected $signature = 'p:info';

    /**
     * VersionCommand constructor.
     */
    public function __construct(private ConfigRepository $config, private SoftwareVersionService $versionService)
    {
        parent::__construct();
    }

    /**
     * Handle execution of command.
     */
    public function handle()
    {
        $this->output->title('Informations sur la version');
        $this->table([], [
            ['Version du Panel', $this->config->get('app.version')],
            ['Dernière version', $this->versionService->getPanel()],
            ['À jour', $this->versionService->isLatestPanel() ? 'Oui' : $this->formatText('Non', 'bg=red')],
            ['Identifiant unique', $this->config->get('pterodactyl.service.author')],
        ], 'compact');

        $this->output->title('Configuration de l’application');
        $this->table([], [
            ['Environnement', $this->formatText($this->config->get('app.env'), $this->config->get('app.env') === 'production' ?: 'bg=red')],
            ['Mode débogage', $this->formatText($this->config->get('app.debug') ? 'Oui' : 'Non', !$this->config->get('app.debug') ?: 'bg=red')],
            ['URL d’installation', $this->config->get('app.url')],
            ['Répertoire d’installation', base_path()],
            ['Fuseau horaire', $this->config->get('app.timezone')],
            ['Pilote de cache', $this->config->get('cache.default')],
            ['Pilote de file d’attente', $this->config->get('queue.default')],
            ['Pilote de session', $this->config->get('session.driver')],
            ['Pilote du système de fichiers', $this->config->get('filesystems.default')],
            ['Thème par défaut', $this->config->get('themes.active')],
            ['Proxys', $this->config->get('trustedproxies.proxies')],
        ], 'compact');

        $this->output->title('Configuration de la base de données');
        $driver = $this->config->get('database.default');
        $this->table([], [
            ['Pilote', $driver],
            ['Hôte', $this->config->get("database.connections.$driver.host")],
            ['Port', $this->config->get("database.connections.$driver.port")],
            ['Base de données', $this->config->get("database.connections.$driver.database")],
            ['Nom d’utilisateur', $this->config->get("database.connections.$driver.username")],
        ], 'compact');

        // TODO: Update this to handle other mail drivers
        $this->output->title('Configuration des e-mails');
        $this->table([], [
            ['Pilote', $this->config->get('mail.default')],
            ['Hôte', $this->config->get('mail.mailers.smtp.host')],
            ['Port', $this->config->get('mail.mailers.smtp.port')],
            ['Nom d’utilisateur', $this->config->get('mail.mailers.smtp.username')],
            ['Adresse d’expédition', $this->config->get('mail.from.address')],
            ['Nom d’expédition', $this->config->get('mail.from.name')],
            ['Chiffrement', $this->config->get('mail.mailers.smtp.encryption')],
        ], 'compact');
    }

    /**
     * Format output in a Name: Value manner.
     */
    private function formatText(string $value, string $opts = ''): string
    {
        return sprintf('<%s>%s</>', $opts, $value);
    }
}
