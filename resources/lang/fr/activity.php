<?php

/**
 * Traductions des événements du journal d’activité.
 * Les clés correspondent aux événements internes de Pterodactyl
 * et ne doivent pas être modifiées.
 */
return [
    'auth' => [
        'fail' => 'Échec de la connexion',
        'success' => 'Connexion réussie',
        'password-reset' => 'Mot de passe réinitialisé',
        'reset-password' => 'Réinitialisation du mot de passe demandée',
        'checkpoint' => 'Authentification à deux facteurs demandée',
        'recovery-token' => 'Jeton de récupération à deux facteurs utilisé',
        'token' => 'Validation de l’authentification à deux facteurs réussie',
        'ip-blocked' => 'Requête bloquée depuis une adresse IP non autorisée pour :identifier',
        'sftp' => [
            'fail' => 'Échec de la connexion SFTP',
        ],
    ],

    'user' => [
        'user' => [
            'create' => 'Nouvel utilisateur créé : :email',
        ],
        'account' => [
            'email-changed' => 'Adresse e-mail modifiée de :old vers :new',
            'password-changed' => 'Mot de passe modifié',
        ],
        'api-key' => [
            'create' => 'Nouvelle clé API créée : :identifier',
            'delete' => 'Clé API supprimée : :identifier',
        ],
        'ssh-key' => [
            'create' => 'Clé SSH :fingerprint ajoutée au compte',
            'delete' => 'Clé SSH :fingerprint supprimée du compte',
        ],
        'two-factor' => [
            'create' => 'Authentification à deux facteurs activée',
            'delete' => 'Authentification à deux facteurs désactivée',
        ],
    ],

    'server' => [
        'reinstall' => 'Serveur réinstallé',

        'console' => [
            'command' => 'Commande « :command » exécutée sur le serveur',
        ],

        'power' => [
            'start' => 'Serveur démarré',
            'stop' => 'Serveur arrêté',
            'restart' => 'Serveur redémarré',
            'kill' => 'Processus du serveur arrêté de force',
        ],

        'backup' => [
            'download' => 'Sauvegarde :name téléchargée',
            'delete' => 'Sauvegarde :name supprimée',
            'restore' => 'Sauvegarde :name restaurée (fichiers supprimés : :truncate)',
            'restore-complete' => 'Restauration de la sauvegarde :name terminée',
            'restore-failed' => 'Échec de la restauration de la sauvegarde :name',
            'start' => 'Nouvelle sauvegarde démarrée : :name',
            'complete' => 'Sauvegarde :name marquée comme terminée',
            'fail' => 'Sauvegarde :name marquée comme échouée',
            'lock' => 'Sauvegarde :name verrouillée',
            'unlock' => 'Sauvegarde :name déverrouillée',
        ],

        'database' => [
            'create' => 'Nouvelle base de données créée : :name',
            'rotate-password' => 'Mot de passe renouvelé pour la base de données :name',
            'delete' => 'Base de données :name supprimée',
        ],

        'file' => [
            'compress_one' => 'Compression de :directory:files.0',
            'compress_other' => 'Compression de :count fichiers dans :directory',
            'read' => 'Contenu du fichier :file consulté',
            'copy' => 'Copie du fichier :file créée',
            'create-directory' => 'Dossier :directory:name créé',
            'decompress' => 'Décompression de :files dans :directory',
            'delete_one' => 'Suppression de :directory:files.0',
            'delete_other' => 'Suppression de :count fichiers dans :directory',
            'download' => 'Fichier :file téléchargé',
            'pull' => 'Fichier distant téléchargé depuis :url vers :directory',
            'rename_one' => 'Renommage de :directory:files.0.from en :directory:files.0.to',
            'rename_other' => 'Renommage de :count fichiers dans :directory',
            'write' => 'Nouveau contenu écrit dans :file',
            'upload' => 'Téléversement d’un fichier démarré',
            'uploaded' => 'Fichier :directory:file téléversé',
        ],

        'sftp' => [
            'denied' => 'Accès SFTP bloqué en raison des permissions',
            'create_one' => 'Fichier :files.0 créé',
            'create_other' => ':count nouveaux fichiers créés',
            'write_one' => 'Contenu de :files.0 modifié',
            'write_other' => 'Contenu de :count fichiers modifié',
            'delete_one' => 'Fichier :files.0 supprimé',
            'delete_other' => ':count fichiers supprimés',
            'create-directory_one' => 'Dossier :files.0 créé',
            'create-directory_other' => ':count dossiers créés',
            'rename_one' => 'Renommage de :files.0.from en :files.0.to',
            'rename_other' => ':count fichiers renommés ou déplacés',
        ],

        'allocation' => [
            'create' => 'Allocation :allocation ajoutée au serveur',
            'notes' => 'Notes de :allocation modifiées de « :old » vers « :new »',
            'primary' => ':allocation définie comme allocation principale du serveur',
            'delete' => 'Allocation :allocation supprimée',
        ],

        'schedule' => [
            'create' => 'Planification :name créée',
            'update' => 'Planification :name mise à jour',
            'execute' => 'Planification :name exécutée manuellement',
            'delete' => 'Planification :name supprimée',
        ],

        'task' => [
            'create' => 'Nouvelle tâche « :action » créée pour la planification :name',
            'update' => 'Tâche « :action » mise à jour pour la planification :name',
            'delete' => 'Tâche supprimée de la planification :name',
        ],

        'settings' => [
            'rename' => 'Serveur renommé de :old en :new',
            'description' => 'Description du serveur modifiée de :old vers :new',
        ],

        'startup' => [
            'edit' => 'Variable :variable modifiée de « :old » vers « :new »',
            'image' => 'Image Docker du serveur mise à jour de :old vers :new',
        ],

        'subuser' => [
            'create' => ':email ajouté comme sous-utilisateur',
            'update' => 'Permissions du sous-utilisateur :email mises à jour',
            'delete' => ':email supprimé des sous-utilisateurs',
        ],
    ],
];
