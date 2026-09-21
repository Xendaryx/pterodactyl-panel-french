<?php

namespace Pterodactyl\Exceptions\Http\Server;

use Pterodactyl\Exceptions\DisplayException;

class FileSizeTooLargeException extends DisplayException
{
    /**
     * FileSizeTooLargeException constructor.
     */
    public function __construct()
    {
        parent::__construct('Le fichier que vous tentez d’ouvrir est trop volumineux pour être affiché dans l’éditeur de fichiers.');
    }
}
