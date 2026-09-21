<?php

namespace Pterodactyl\Console\Commands\Node;

use Illuminate\Console\Command;
use Pterodactyl\Services\Nodes\NodeCreationService;

class MakeNodeCommand extends Command
{
    protected $signature = 'p:node:make
                            {--name= : Un nom permettant d’identifier le nœud.}
                            {--description= : Une description permettant d’identifier le nœud.}
                            {--locationId= : Un ID d’emplacement valide.}
                            {--fqdn= : Le nom de domaine (par ex. node.example.com) utilisé pour se connecter au daemon. Une adresse IP ne peut être utilisée que si SSL n’est pas activé pour ce nœud.}
                            {--public= : Le nœud doit-il être public ou privé ? (public=1 / privé=0).}
                            {--scheme= : Quel protocole doit être utilisé ? (Activer SSL=https / Désactiver SSL=http).}
                            {--proxy= : Le daemon se trouve-t-il derrière un proxy ? (Oui=1 / Non=0).}
                            {--maintenance= : Le mode maintenance doit-il être activé ? (Activer=1 / Désactiver=0).}
                            {--maxMemory= : Définissez la quantité maximale de mémoire.}
                            {--overallocateMemory= : Saisissez le taux de surallocation de RAM (% ou -1 pour autoriser le maximum).}
                            {--maxDisk= : Définissez la quantité maximale d’espace disque.}
                            {--overallocateDisk= : Saisissez le taux de surallocation du disque (% ou -1 pour autoriser le maximum).}
                            {--uploadSize= : Saisissez la taille maximale des fichiers téléversés.}
                            {--daemonListeningPort= : Saisissez le port d’écoute de Wings.}
                            {--daemonSFTPPort= : Saisissez le port d’écoute SFTP de Wings.}
                            {--daemonBase= : Saisissez le dossier de base.}';

    protected $description = 'Crée un nouveau nœud sur le système via l’interface en ligne de commande.';

    /**
     * MakeNodeCommand constructor.
     */
    public function __construct(private NodeCreationService $creationService)
    {
        parent::__construct();
    }

    /**
     * Handle the command execution process.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     */
    public function handle()
    {
        $data['name'] = $this->option('name') ?? $this->ask('Saisissez un identifiant court permettant de distinguer ce nœud des autres');
        $data['description'] = $this->option('description') ?? $this->ask('Saisissez une description permettant d’identifier le nœud');
        $data['location_id'] = $this->option('locationId') ?? $this->ask('Saisissez un ID d’emplacement valide');
        $data['scheme'] = $this->option('scheme') ?? $this->anticipate(
            'Saisissez https pour une connexion SSL ou http pour une connexion sans SSL',
            ['https', 'http'],
            'https'
        );
        $data['fqdn'] = $this->option('fqdn') ?? $this->ask('Saisissez un nom de domaine (par ex. node.example.com) à utiliser pour la connexion au daemon. Une adresse IP ne peut être utilisée que si SSL n’est pas activé pour ce nœud');
        $data['public'] = $this->option('public') ?? $this->confirm('Ce nœud doit-il être public ? Un nœud défini comme privé ne pourra pas recevoir de déploiements automatiques.', true);
        $data['behind_proxy'] = $this->option('proxy') ?? $this->confirm('Votre FQDN se trouve-t-il derrière un proxy ?');
        $data['maintenance_mode'] = $this->option('maintenance') ?? $this->confirm('Le mode maintenance doit-il être activé ?');
        $data['memory'] = $this->option('maxMemory') ?? $this->ask('Saisissez la quantité maximale de mémoire');
        $data['memory_overallocate'] = $this->option('overallocateMemory') ?? $this->ask('Saisissez le taux de surallocation de mémoire ; -1 désactive la vérification et 0 empêche la création de nouveaux serveurs');
        $data['disk'] = $this->option('maxDisk') ?? $this->ask('Saisissez la quantité maximale d’espace disque');
        $data['disk_overallocate'] = $this->option('overallocateDisk') ?? $this->ask('Saisissez le taux de surallocation d’espace disque ; -1 désactive la vérification et 0 empêche la création de nouveaux serveurs');
        $data['upload_size'] = $this->option('uploadSize') ?? $this->ask('Saisissez la taille maximale des fichiers téléversés', '100');
        $data['daemonListen'] = $this->option('daemonListeningPort') ?? $this->ask('Saisissez le port d’écoute de Wings', '8080');
        $data['daemonSFTP'] = $this->option('daemonSFTPPort') ?? $this->ask('Saisissez le port d’écoute SFTP de Wings', '2022');
        $data['daemonBase'] = $this->option('daemonBase') ?? $this->ask('Saisissez le dossier de base', '/var/lib/pterodactyl/volumes');

        $node = $this->creationService->handle($data);
        $this->line('Nouveau nœud créé avec succès dans l’emplacement ' . $data['location_id'] . ' avec le nom ' . $data['name'] . ' et l’ID ' . $node->id . '.');
    }
}
