<?php

namespace Pterodactyl\Http\Middleware\Admin\Servers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pterodactyl\Models\Server;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServerInstalled
{
    /**
     * Checks that the server is installed before allowing access through the route.
     */
    public function handle(Request $request, \Closure $next): mixed
    {
        /** @var Server|null $server */
        $server = $request->route()->parameter('server');

        if (!$server instanceof Server) {
            throw new NotFoundHttpException('Aucune ressource serveur n’a été trouvée dans les paramètres de la requête.');
        }

        if (!$server->isInstalled()) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'L’accès à cette ressource n’est pas autorisé en raison de l’état actuel de l’installation.');
        }

        return $next($request);
    }
}
