<?php

namespace Pterodactyl\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\VarDumper\VarDumper;
use Pterodactyl\Services\Telemetry\TelemetryCollectionService;

class TelemetryCommand extends Command
{
    protected $description = 'Affiche toutes les données qui seraient envoyées au service de télémétrie Pterodactyl si la collecte de télémétrie est activée.';

    protected $signature = 'p:telemetry';

    /**
     * TelemetryCommand constructor.
     */
    public function __construct(private TelemetryCollectionService $telemetryCollectionService)
    {
        parent::__construct();
    }

    /**
     * Handle execution of command.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     */
    public function handle()
    {
        $this->output->info('Collecte des données de télémétrie en cours, cela peut prendre un certain temps...');

        VarDumper::dump($this->telemetryCollectionService->collect());
    }
}
