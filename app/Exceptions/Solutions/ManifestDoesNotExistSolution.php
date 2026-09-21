<?php

namespace Pterodactyl\Exceptions\Solutions;

use Spatie\Ignition\Contracts\Solution;

class ManifestDoesNotExistSolution implements Solution
{
    public function getSolutionTitle(): string
    {
        return "Le fichier manifest.json n’a pas encore été généré";
    }

    public function getSolutionDescription(): string
    {
        return 'Exécutez yarn run build:production afin de compiler d’abord le frontend.';
    }

    public function getDocumentationLinks(): array
    {
        return [
            'Documentation' => 'https://github.com/pterodactyl/panel/blob/develop/package.json',
        ];
    }
}
