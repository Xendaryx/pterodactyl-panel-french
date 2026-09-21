<?php

namespace Pterodactyl\Models;

use Illuminate\Support\Collection;

class Permission extends Model
{
    /**
     * The resource name for this model when it is transformed into an
     * API representation using fractal.
     */
    public const RESOURCE_NAME = 'subuser_permission';

    /**
     * Constants defining different permissions available.
     */
    public const ACTION_WEBSOCKET_CONNECT = 'websocket.connect';
    public const ACTION_CONTROL_CONSOLE = 'control.console';
    public const ACTION_CONTROL_START = 'control.start';
    public const ACTION_CONTROL_STOP = 'control.stop';
    public const ACTION_CONTROL_RESTART = 'control.restart';

    public const ACTION_DATABASE_READ = 'database.read';
    public const ACTION_DATABASE_CREATE = 'database.create';
    public const ACTION_DATABASE_UPDATE = 'database.update';
    public const ACTION_DATABASE_DELETE = 'database.delete';
    public const ACTION_DATABASE_VIEW_PASSWORD = 'database.view_password';

    public const ACTION_SCHEDULE_READ = 'schedule.read';
    public const ACTION_SCHEDULE_CREATE = 'schedule.create';
    public const ACTION_SCHEDULE_UPDATE = 'schedule.update';
    public const ACTION_SCHEDULE_DELETE = 'schedule.delete';

    public const ACTION_USER_READ = 'user.read';
    public const ACTION_USER_CREATE = 'user.create';
    public const ACTION_USER_UPDATE = 'user.update';
    public const ACTION_USER_DELETE = 'user.delete';

    public const ACTION_BACKUP_READ = 'backup.read';
    public const ACTION_BACKUP_CREATE = 'backup.create';
    public const ACTION_BACKUP_DELETE = 'backup.delete';
    public const ACTION_BACKUP_DOWNLOAD = 'backup.download';
    public const ACTION_BACKUP_RESTORE = 'backup.restore';

    public const ACTION_ALLOCATION_READ = 'allocation.read';
    public const ACTION_ALLOCATION_CREATE = 'allocation.create';
    public const ACTION_ALLOCATION_UPDATE = 'allocation.update';
    public const ACTION_ALLOCATION_DELETE = 'allocation.delete';

    public const ACTION_FILE_READ = 'file.read';
    public const ACTION_FILE_READ_CONTENT = 'file.read-content';
    public const ACTION_FILE_CREATE = 'file.create';
    public const ACTION_FILE_UPDATE = 'file.update';
    public const ACTION_FILE_DELETE = 'file.delete';
    public const ACTION_FILE_ARCHIVE = 'file.archive';
    public const ACTION_FILE_SFTP = 'file.sftp';

    public const ACTION_STARTUP_READ = 'startup.read';
    public const ACTION_STARTUP_UPDATE = 'startup.update';
    public const ACTION_STARTUP_DOCKER_IMAGE = 'startup.docker-image';

    public const ACTION_SETTINGS_RENAME = 'settings.rename';
    public const ACTION_SETTINGS_REINSTALL = 'settings.reinstall';

    public const ACTION_ACTIVITY_READ = 'activity.read';

    /**
     * Should timestamps be used on this model.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected $table = 'permissions';

    /**
     * Fields that are not mass assignable.
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Cast values to correct type.
     */
    protected $casts = [
        'subuser_id' => 'integer',
    ];

    public static array $validationRules = [
        'subuser_id' => 'required|numeric|min:1',
        'permission' => 'required|string',
    ];

    /**
     * All the permissions available on the system. You should use self::permissions()
     * to retrieve them, and not directly access this array as it is subject to change.
     *
     * @see \Pterodactyl\Models\Permission::permissions()
     */
    protected static array $permissions = [
        'websocket' => [
            'description' => 'Autorise l’utilisateur à se connecter au WebSocket du serveur afin d’accéder à la sortie de la console et aux statistiques du serveur en temps réel.',
            'keys' => [
                'connect' => 'Autorise un utilisateur à se connecter à l’instance WebSocket d’un serveur afin de recevoir la console en temps réel.',
            ],
        ],

        'control' => [
            'description' => 'Permissions permettant à un utilisateur de contrôler l’état d’alimentation d’un serveur ou d’envoyer des commandes.',
            'keys' => [
                'console' => 'Autorise un utilisateur à envoyer des commandes à l’instance du serveur via la console.',
                'start' => 'Autorise un utilisateur à démarrer le serveur s’il est arrêté.',
                'stop' => 'Autorise un utilisateur à arrêter un serveur s’il est en cours d’exécution.',
                'restart' => 'Autorise un utilisateur à redémarrer un serveur. Cette permission lui permet de démarrer le serveur s’il est hors ligne, mais pas de le placer dans un état complètement arrêté.',
            ],
        ],

        'user' => [
            'description' => 'Permissions permettant à un utilisateur de gérer les autres sous-utilisateurs d’un serveur. Il ne pourra jamais modifier son propre compte ni attribuer des permissions qu’il ne possède pas lui-même.',
            'keys' => [
                'create' => 'Autorise un utilisateur à créer de nouveaux sous-utilisateurs pour le serveur.',
                'read' => 'Autorise l’utilisateur à consulter les sous-utilisateurs et leurs permissions pour le serveur.',
                'update' => 'Autorise un utilisateur à modifier les autres sous-utilisateurs.',
                'delete' => 'Autorise un utilisateur à supprimer un sous-utilisateur du serveur.',
            ],
        ],

        'file' => [
            'description' => 'Permissions permettant à un utilisateur de modifier le système de fichiers de ce serveur.',
            'keys' => [
                'create' => 'Autorise un utilisateur à créer des fichiers et dossiers supplémentaires via le Panel ou par téléversement direct.',
                'read' => 'Autorise un utilisateur à consulter le contenu d’un dossier, sans pouvoir consulter le contenu des fichiers ni les télécharger.',
                'read-content' => 'Autorise un utilisateur à consulter le contenu d’un fichier donné. Cette permission lui permet également de télécharger des fichiers.',
                'update' => 'Autorise un utilisateur à modifier le contenu d’un fichier ou dossier existant.',
                'delete' => 'Autorise un utilisateur à supprimer des fichiers ou des dossiers.',
                'archive' => 'Autorise un utilisateur à archiver le contenu d’un dossier ainsi qu’à décompresser les archives existantes sur le système.',
                'sftp' => 'Autorise un utilisateur à se connecter en SFTP et à gérer les fichiers du serveur selon les autres permissions de fichiers qui lui sont attribuées.',
            ],
        ],

        'backup' => [
            'description' => 'Permissions permettant à un utilisateur de créer et de gérer les sauvegardes du serveur.',
            'keys' => [
                'create' => 'Autorise un utilisateur à créer de nouvelles sauvegardes pour ce serveur.',
                'read' => 'Autorise un utilisateur à consulter toutes les sauvegardes existantes pour ce serveur.',
                'delete' => 'Autorise un utilisateur à supprimer des sauvegardes du système.',
                'download' => 'Autorise un utilisateur à télécharger une sauvegarde du serveur. Danger : cette permission lui donne accès à tous les fichiers du serveur présents dans la sauvegarde.',
                'restore' => 'Autorise un utilisateur à restaurer une sauvegarde du serveur. Danger : cette opération peut supprimer tous les fichiers du serveur pendant le processus.',
            ],
        ],

        // Controls permissions for editing or viewing a server's allocations.
        'allocation' => [
            'description' => 'Permissions permettant à un utilisateur de modifier les allocations de ports de ce serveur.',
            'keys' => [
                'read' => 'Autorise un utilisateur à consulter toutes les allocations actuellement attribuées à ce serveur. Tout utilisateur disposant d’un accès à ce serveur peut toujours consulter l’allocation principale.',
                'create' => 'Autorise un utilisateur à attribuer des allocations supplémentaires au serveur.',
                'update' => 'Autorise un utilisateur à modifier l’allocation principale du serveur et à ajouter des notes à chaque allocation.',
                'delete' => 'Autorise un utilisateur à supprimer une allocation du serveur.',
            ],
        ],

        // Controls permissions for editing or viewing a server's startup parameters.
        'startup' => [
            'description' => 'Permissions permettant à un utilisateur de consulter les paramètres de démarrage de ce serveur.',
            'keys' => [
                'read' => 'Autorise un utilisateur à consulter les variables de démarrage d’un serveur.',
                'update' => 'Autorise un utilisateur à modifier les variables de démarrage du serveur.',
                'docker-image' => 'Autorise un utilisateur à modifier l’image Docker utilisée lors de l’exécution du serveur.',
            ],
        ],

        'database' => [
            'description' => 'Permissions contrôlant l’accès d’un utilisateur à la gestion des bases de données de ce serveur.',
            'keys' => [
                'create' => 'Autorise un utilisateur à créer une nouvelle base de données pour ce serveur.',
                'read' => 'Autorise un utilisateur à consulter la base de données associée à ce serveur.',
                'update' => 'Autorise un utilisateur à renouveler le mot de passe d’une instance de base de données. Si l’utilisateur ne possède pas la permission view_password, il ne verra pas le nouveau mot de passe.',
                'delete' => 'Autorise un utilisateur à supprimer une instance de base de données de ce serveur.',
                'view_password' => 'Autorise un utilisateur à consulter le mot de passe associé à une instance de base de données de ce serveur.',
            ],
        ],

        'schedule' => [
            'description' => 'Permissions contrôlant l’accès d’un utilisateur à la gestion des planifications de ce serveur.',
            'keys' => [
                'create' => 'Autorise un utilisateur à créer de nouvelles planifications pour ce serveur.', // task.create-schedule
                'read' => 'Autorise un utilisateur à consulter les planifications et les tâches qui leur sont associées pour ce serveur.', // task.view-schedule, task.list-schedules
                'update' => 'Autorise un utilisateur à modifier les planifications et leurs tâches pour ce serveur.', // task.edit-schedule, task.queue-schedule, task.toggle-schedule
                'delete' => 'Autorise un utilisateur à supprimer des planifications de ce serveur.', // task.delete-schedule
            ],
        ],

        'settings' => [
            'description' => 'Permissions contrôlant l’accès d’un utilisateur aux paramètres de ce serveur.',
            'keys' => [
                'rename' => 'Autorise un utilisateur à renommer ce serveur et à modifier sa description.',
                'reinstall' => 'Autorise un utilisateur à déclencher la réinstallation de ce serveur.',
            ],
        ],

        'activity' => [
            'description' => 'Permissions contrôlant l’accès d’un utilisateur aux journaux d’activité du serveur.',
            'keys' => [
                'read' => 'Autorise un utilisateur à consulter les journaux d’activité du serveur.',
            ],
        ],
    ];

    /**
     * Returns all the permissions available on the system for a user to
     * have when controlling a server.
     */
    public static function permissions(): Collection
    {
        return Collection::make(self::$permissions);
    }
}
