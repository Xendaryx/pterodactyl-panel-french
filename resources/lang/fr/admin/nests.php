<?php

return [
    'notices' => [
        'created' => 'Le Nid :name a été créé avec succès.',
        'deleted' => 'Le Nid demandé a été supprimé du panel avec succès.',
        'updated' => 'Les options de configuration du Nid ont été mises à jour avec succès.',
    ],
    'eggs' => [
        'notices' => [
            'imported' => 'Cet Egg et ses variables associées ont été importés avec succès.',
            'updated_via_import' => 'Cet Egg a été mis à jour à l’aide du fichier fourni.',
            'deleted' => 'L’Egg demandé a été supprimé du panel avec succès.',
            'updated' => 'La configuration de l’Egg a été mise à jour avec succès.',
            'script_updated' => 'Le script d’installation de l’Egg a été mis à jour et sera exécuté lors de l’installation des serveurs.',
            'egg_created' => 'Un nouvel Egg a été créé avec succès. Vous devrez redémarrer les daemons en cours d’exécution pour appliquer ce nouvel Egg.',
        ],
    ],
    'variables' => [
        'notices' => [
            'variable_deleted' => 'La variable ":variable" a été supprimée et ne sera plus disponible pour les serveurs après leur reconstruction.',
            'variable_updated' => 'La variable ":variable" a été mise à jour. Vous devrez reconstruire les serveurs utilisant cette variable afin d’appliquer les modifications.',
            'variable_created' => 'Une nouvelle variable a été créée avec succès et attribuée à cet Egg.',
        ],
    ],
];
