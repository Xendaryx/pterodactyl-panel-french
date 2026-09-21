<?php

namespace Pterodactyl\Console\Commands\Location;

use Illuminate\Console\Command;
use Pterodactyl\Services\Locations\LocationCreationService;

class MakeLocationCommand extends Command
{
    protected $signature = 'p:location:make
                            {--short= : Le nom court de cet emplacement (ex. fr1).}
                            {--long= : Une description plus détaillée de cet emplacement.}';

    protected $description = 'Crée un nouvel emplacement sur le système via l’interface en ligne de commande.';

    /**
     * Create a new command instance.
     */
    public function __construct(private LocationCreationService $creationService)
    {
        parent::__construct();
    }

    /**
     * Handle the command execution process.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     */
    public function handle()
    {
        $short = $this->option('short') ?? $this->ask(trans('command/messages.location.ask_short'));
        $long = $this->option('long') ?? $this->ask(trans('command/messages.location.ask_long'));

        $location = $this->creationService->handle(compact('short', 'long'));
        $this->line(trans('command/messages.location.created', [
            'name' => $location->short,
            'id' => $location->id,
        ]));
    }
}
