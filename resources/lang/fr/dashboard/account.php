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
        'button' => 'Configure 2-Factor Authentication',
        'disabled' => 'L’authentification à deux facteurs a été désactivée sur votre compte. Aucun jeton ne vous sera désormais demandé lors de la connexion.',
        'enabled' => 'L’authentification à deux facteurs a été activée sur votre compte ! Désormais, lors de la connexion, vous devrez fournir le code généré par votre appareil.',
        'invalid' => 'Le jeton fourni n’était pas valide.',
        'setup' => [
            'title' => 'Setup two-factor authentication',
            'help' => 'Can\'t scan the code? Enter the code below into your application:',
            'field' => 'Enter token',
        ],
        'disable' => [
            'title' => 'Désactiver l’authentification à deux facteurs',
            'field' => 'Enter token',
        ],
    ],
];
