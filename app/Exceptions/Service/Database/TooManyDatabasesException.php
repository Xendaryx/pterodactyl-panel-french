<?php

namespace Pterodactyl\Exceptions\Service\Database;

use Pterodactyl\Exceptions\DisplayException;

class TooManyDatabasesException extends DisplayException
{
    public function __construct()
    {
        parent::__construct('Opération annulée : la création d’une nouvelle base de données dépasserait la limite définie pour ce serveur.');
    }
}
