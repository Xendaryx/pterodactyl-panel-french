<?php

namespace Pterodactyl\Console\Commands\Node;

use Pterodactyl\Models\Node;
use Illuminate\Console\Command;

class NodeConfigurationCommand extends Command
{
    protected $signature = 'p:node:configuration
                            {node : L’ID ou l’UUID du nœud dont la configuration doit être affichée.}
                            {--format=yaml : Le format de sortie. Les options disponibles sont "yaml" et "json".}';

    protected $description = 'Affiche la configuration du nœud spécifié.';

    public function handle(): int
    {
        $column = ctype_digit((string) $this->argument('node')) ? 'id' : 'uuid';

        /** @var Node $node */
        $node = Node::query()->where($column, $this->argument('node'))->firstOr(function () {
            $this->error('Le nœud sélectionné n’existe pas.');

            exit(1);
        });

        $format = $this->option('format');
        if (!in_array($format, ['yaml', 'yml', 'json'])) {
            $this->error('Format spécifié invalide. Les options valides sont "yaml" et "json".');

            return 1;
        }

        if ($format === 'json') {
            $this->output->write($node->getJsonConfiguration(true));
        } else {
            $this->output->write($node->getYamlConfiguration());
        }

        $this->output->newLine();

        return 0;
    }
}
