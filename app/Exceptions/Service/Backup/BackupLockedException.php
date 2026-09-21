<?php

namespace Pterodactyl\Exceptions\Service\Backup;

use Pterodactyl\Exceptions\DisplayException;

class BackupLockedException extends DisplayException
{
    /**
     * TooManyBackupsException constructor.
     */
    public function __construct()
    {
        parent::__construct('Impossible de supprimer une sauvegarde marquée comme verrouillée.');
    }
}
