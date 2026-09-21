<?php

namespace Pterodactyl\Exceptions\Service\Backup;

use Pterodactyl\Exceptions\DisplayException;

class TooManyBackupsException extends DisplayException
{
    /**
     * TooManyBackupsException constructor.
     */
    public function __construct(int $backupLimit)
    {
        parent::__construct(
            sprintf('Impossible de créer une nouvelle sauvegarde : ce serveur a atteint sa limite de %d sauvegardes.', $backupLimit)
        );
    }
}
