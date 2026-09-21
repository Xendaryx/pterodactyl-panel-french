<?php

namespace Pterodactyl\Exceptions\Http\Server;

use Pterodactyl\Models\Server;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ServerStateConflictException extends ConflictHttpException
{
    /**
     * Exception thrown when the server is in an unsupported state for API access or
     * certain operations within the codebase.
     */
    public function __construct(Server $server, ?\Throwable $previous = null)
    {
        $message = 'Ce serveur est actuellement dans un état non pris en charge. Veuillez réessayer plus tard.';
        if ($server->isSuspended()) {
            $message = 'Ce serveur est actuellement suspendu et la fonctionnalité demandée est indisponible.';
        } elseif ($server->node->isUnderMaintenance()) {
            $message = 'Le nœud de ce serveur est actuellement en maintenance et la fonctionnalité demandée est indisponible.';
        } elseif (!$server->isInstalled()) {
            $message = 'Ce serveur n’a pas encore terminé son installation. Veuillez réessayer plus tard.';
        } elseif ($server->status === Server::STATUS_RESTORING_BACKUP) {
            $message = 'Ce serveur restaure actuellement une sauvegarde. Veuillez réessayer plus tard.';
        } elseif (!is_null($server->transfer)) {
            $message = 'Ce serveur est actuellement transféré vers une nouvelle machine. Veuillez réessayer plus tard.';
        }

        parent::__construct($message, $previous);
    }
}
