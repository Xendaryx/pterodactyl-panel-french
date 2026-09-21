<?php

namespace Pterodactyl\Console\Commands\Overrides;

use Illuminate\Foundation\Console\KeyGenerateCommand as BaseKeyGenerateCommand;

class KeyGenerateCommand extends BaseKeyGenerateCommand
{
    /**
     * Override the default Laravel key generation command to throw a warning to the user
     * if it appears that they have already generated an application encryption key.
     */
    public function handle()
    {
        if (!empty(config('app.key')) && $this->input->isInteractive()) {
            $this->output->warning('Il semble que vous ayez déjà configuré une clé de chiffrement pour l’application. Poursuivre cette opération écrasera cette clé et entraînera la corruption des données chiffrées existantes. NE CONTINUEZ PAS À MOINS DE SAVOIR EXACTEMENT CE QUE VOUS FAITES.');
            if (!$this->confirm('Je comprends les conséquences de l’exécution de cette commande et j’accepte l’entière responsabilité de la perte des données chiffrées.')) {
                return;
            }

            if (!$this->confirm('Êtes-vous sûr de vouloir continuer ? La modification de la clé de chiffrement de l’application ENTRAÎNERA UNE PERTE DE DONNÉES.')) {
                return;
            }
        }

        parent::handle();
    }
}
