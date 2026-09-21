<?php

return [
    'location' => [
        'no_location_found' => 'Impossible de trouver un emplacement correspondant au code court fourni.',
        'ask_short' => 'Code court de l’emplacement',
        'ask_long' => 'Description de l’emplacement',
        'created' => 'Nouvel emplacement (:name) créé avec succès avec l’ID :id.',
        'deleted' => 'L’emplacement demandé a été supprimé avec succès.',
    ],
    'user' => [
        'search_users' => 'Saisissez un nom d’utilisateur, un ID utilisateur ou une adresse e-mail',
        'select_search_user' => 'ID de l’utilisateur à supprimer (saisissez \'0\' pour effectuer une nouvelle recherche)',
        'deleted' => 'L’utilisateur a été supprimé du Panel avec succès.',
        'confirm_delete' => 'Êtes-vous sûr de vouloir supprimer cet utilisateur du Panel ?',
        'no_users_found' => 'Aucun utilisateur n’a été trouvé pour le terme de recherche fourni.',
        'multiple_found' => 'Plusieurs comptes correspondent à l’utilisateur fourni. Impossible de supprimer un utilisateur en raison de l’option --no-interaction.',
        'ask_admin' => 'Cet utilisateur est-il administrateur ?',
        'ask_email' => 'Adresse e-mail',
        'ask_username' => 'Nom d’utilisateur',
        'ask_name_first' => 'Prénom',
        'ask_name_last' => 'Nom',
        'ask_password' => 'Mot de passe',
        'ask_password_tip' => 'Si vous souhaitez créer un compte avec un mot de passe aléatoire envoyé par e-mail à l’utilisateur, relancez cette commande (CTRL+C) avec l’option `--no-password`.',
        'ask_password_help' => 'Les mots de passe doivent comporter au moins 8 caractères et contenir au moins une lettre majuscule et un chiffre.',
        '2fa_help_text' => [
            'Cette commande désactivera l’authentification à deux facteurs du compte d’un utilisateur si elle est activée. Elle doit uniquement être utilisée pour récupérer un compte lorsque l’utilisateur ne peut plus y accéder.',
            'Si ce n’est pas l’action souhaitée, appuyez sur CTRL+C pour quitter ce processus.',
        ],
        '2fa_disabled' => 'L’authentification à deux facteurs a été désactivée pour :email.',
    ],
    'schedule' => [
        'output_line' => 'Envoi de la tâche pour la première action de `:schedule` (:hash).',
    ],
    'maintenance' => [
        'deleting_service_backup' => 'Suppression du fichier de sauvegarde du service :file.',
    ],
    'server' => [
        'rebuild_failed' => 'La demande de reconstruction de ":name" (#:id) sur le nœud ":node" a échoué avec l’erreur : :message',
        'reinstall' => [
            'failed' => 'La demande de réinstallation de ":name" (#:id) sur le nœud ":node" a échoué avec l’erreur : :message',
            'confirm' => 'Vous êtes sur le point de réinstaller un groupe de serveurs. Souhaitez-vous continuer ?',
        ],
        'power' => [
            'confirm' => 'Vous êtes sur le point d’effectuer l’action :action sur :count serveurs. Souhaitez-vous continuer ?',
            'action_failed' => 'La demande d’action d’alimentation pour ":name" (#:id) sur le nœud ":node" a échoué avec l’erreur : :message',
        ],
    ],
    'environment' => [
        'mail' => [
            'ask_smtp_host' => 'Hôte SMTP (par ex. smtp.gmail.com)',
            'ask_smtp_port' => 'Port SMTP',
            'ask_smtp_username' => 'Nom d’utilisateur SMTP',
            'ask_smtp_password' => 'Mot de passe SMTP',
            'ask_mailgun_domain' => 'Domaine Mailgun',
            'ask_mailgun_endpoint' => 'Point de terminaison Mailgun',
            'ask_mailgun_secret' => 'Clé secrète Mailgun',
            'ask_mandrill_secret' => 'Clé secrète Mandrill',
            'ask_postmark_username' => 'Clé API Postmark',
            'ask_driver' => 'Quel service doit être utilisé pour envoyer les e-mails ?',
            'ask_mail_from' => 'Adresse e-mail utilisée comme expéditeur',
            'ask_mail_name' => 'Nom d’expéditeur affiché dans les e-mails',
            'ask_encryption' => 'Méthode de chiffrement à utiliser',
        ],
    ],
];
