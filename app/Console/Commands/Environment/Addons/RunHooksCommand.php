<?php

namespace Pterodactyl\Console\Commands\Environment\Addons;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class RunHooksCommand extends Command
{
    protected $signature = 'p:environment:addons:run-hooks
                            {event : L’événement du cycle de vie pour lequel exécuter les hooks (par ex. post-install).}';

    protected $description = 'Exécute les scripts de hooks du cycle de vie des extensions pour l’événement indiqué.';

    /**
     * Runs every executable "addons/<name>/hooks/<event>" script for the given lifecycle event when addon hooks are enabled.
     */
    public function handle(): int
    {
        if (!config('addons.hooks_enabled')) {
            return self::SUCCESS;
        }

        $event = $this->argument('event');
        if (!Str::isMatch('/^[a-z0-9-]+$/', $event)) {
            $this->components->error("Nom d’événement de hook invalide : {$event}");

            return self::INVALID;
        }

        $hooks = Collection::make(File::glob(base_path("addons/*/hooks/{$event}")) ?: [])
            ->filter(fn (string $hook) => is_executable($hook))
            ->values();

        if ($hooks->isEmpty()) {
            return self::SUCCESS;
        }

        if ($this->input->isInteractive() && !$this->confirm(
            sprintf('Exécuter %d script(s) de hook d’extension pour l’événement "%s" ? Ils seront exécutés avec les privilèges de ce processus.', $hooks->count(), $event)
        )) {
            return self::SUCCESS;
        }

        $hooks->each($this->runHook(...));

        return self::SUCCESS;
    }

    /**
     * Streams a single hook's output, reporting a non-zero exit without aborting the remaining hooks.
     */
    private function runHook(string $hook): void
    {
        $this->components->info("Exécution du hook d’extension : {$hook}");

        $result = Process::path(base_path())
            ->forever()
            ->run([$hook], fn (string $type, string $output) => $this->output->write($output));

        if ($result->failed()) {
            $this->components->warn("Le hook d’extension s’est terminé avec une erreur : {$hook}");
        }
    }
}
