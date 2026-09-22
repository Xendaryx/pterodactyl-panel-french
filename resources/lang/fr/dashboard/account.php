<?php

return [
    'email' => [
        'title' => 'Modifier votre adresse e-mail',
        'updated' => 'Votre adresse e-mail a été mise à jour.',
    ],
    'password' => [
        'title' => 'Modifier votre mot de passe',
        'requirements' => 'Votre nouveau mot de passe doit contenir au moins 8 caractères.',
        'updated' => 'Votre mot de passe a été mis à jour.',
    ],
    'two_factor' => [
        'button' => 'Configurer l’authentification à deux facteurs',
        'disabled' => 'L’authentification à deux facteurs a été désactivée sur votre compte. Aucun jeton ne vous sera désormais demandé lors de la connexion.',
        'enabled' => 'L’authentification à deux facteurs a été activée sur votre compte ! Désormais, lors de la connexion, vous devrez fournir le code généré par votre appareil.',
        'invalid' => 'Le jeton fourni n’était pas valide.',
        'setup' => [
            'title' => 'Configurer l’authentification à deux facteurs',
            'help' => 'Impossible de scanner le code ? Saisissez le code ci-dessous dans votre application :',
            'field' => 'Saisissez le code',
        ],
        'disable' => [
            'title' => 'Désactiver l’authentification à deux facteurs',
            'field' => 'Saisissez le code',
        ],
    ],
];
