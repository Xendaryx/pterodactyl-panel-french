<?php

namespace Pterodactyl\Exceptions\Service\Allocation;

use Pterodactyl\Exceptions\DisplayException;

class NoAutoAllocationSpaceAvailableException extends DisplayException
{
    /**
     * NoAutoAllocationSpaceAvailableException constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'Impossible d’attribuer une allocation supplémentaire : aucun emplacement n’est disponible sur le nœud.'
        );
    }
}
