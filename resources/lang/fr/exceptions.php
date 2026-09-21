<?php

return [
    'daemon_connection_failed' => 'Une erreur est survenue lors de la communication avec le daemon, avec un code de réponse HTTP/:code — cette erreur a été enregistrée dans les journaux.',

    'node' => [
        'servers_attached' => 'Un nœud ne peut être supprimé que si aucun serveur ne lui est associé.',
        'daemon_off_config_updated' => 'La configuration du daemon a été mise à jour, mais une erreur est survenue lors de la mise à jour automatique du fichier de configuration sur le daemon. Vous devez mettre à jour manuellement le fichier config.yml pour appliquer ces modifications.',
    ],

    'allocations' => [
        'server_using' => 'Un serveur utilise actuellement cette allocation. Elle ne peut être supprimée tant qu’un serveur lui est associé.',
        'too_many_ports' => 'Il n’est pas possible d’ajouter plus de 1000 ports dans une même plage en une seule fois.',
        'invalid_mapping' => 'L’association fournie pour le port :port est invalide et n’a pas pu être traitée.',
        'cidr_out_of_range' => 'La notation CIDR autorise uniquement les masques compris entre /25 et /32.',
        'port_out_of_range' => 'Les ports d’une allocation doivent être supérieurs à 1024 et inférieurs ou égaux à 65535.',
    ],

    'nest' => [
        'delete_has_servers' => 'Un Nest auquel des serveurs actifs sont associés ne peut pas être supprimé du panel.',

        'egg' => [
            'delete_has_servers' => 'Un Egg auquel des serveurs actifs sont associés ne peut pas être supprimé du panel.',
            'invalid_copy_id' => 'L’Egg sélectionné pour copier un script n’existe pas ou copie lui-même un autre script.',
            'must_be_child' => 'Le paramètre « Copier les paramètres depuis » de cet Egg doit correspondre à une option enfant du Nest sélectionné.',
            'has_children' => 'Cet Egg est le parent d’un ou plusieurs autres Eggs. Supprimez d’abord ces Eggs avant de supprimer celui-ci.',
        ],

        'variables' => [
            'env_not_unique' => 'La variable d’environnement :name doit être unique pour cet Egg.',
            'reserved_name' => 'La variable d’environnement :name est protégée et ne peut pas être attribuée à une variable.',
            'bad_validation_rule' => 'La règle de validation « :rule » n’est pas valide pour cette application.',
        ],

        'importer' => [
            'json_error' => 'Une erreur est survenue lors de l’analyse du fichier JSON : :error.',
            'file_error' => 'Le fichier JSON fourni n’est pas valide.',
            'invalid_json_provided' => 'Le fichier JSON fourni n’est pas dans un format reconnu.',
        ],
    ],

    'subusers' => [
        'editing_self' => 'Vous ne pouvez pas modifier votre propre compte en tant que sous-utilisateur.',
        'user_is_owner' => 'Vous ne pouvez pas ajouter le propriétaire du serveur comme sous-utilisateur de ce serveur.',
        'subuser_exists' => 'Un utilisateur avec cette adresse e-mail est déjà associé à ce serveur en tant que sous-utilisateur.',
    ],

    'databases' => [
        'delete_has_databases' => 'Impossible de supprimer un hôte de bases de données auquel des bases de données actives sont associées.',
    ],

    'tasks' => [
        'chain_interval_too_long' => 'L’intervalle maximal entre deux tâches enchaînées est de 15 minutes.',
    ],

    'locations' => [
        'has_nodes' => 'Impossible de supprimer un emplacement auquel des nœuds actifs sont associés.',
    ],

    'users' => [
        'node_revocation_failed' => 'Impossible de révoquer les clés sur le <a href=":link">nœud #:node</a>. :error',
    ],

    'deployment' => [
        'no_viable_nodes' => 'Aucun nœud répondant aux exigences définies pour le déploiement automatique n’a été trouvé.',
        'no_viable_allocations' => 'Aucune allocation répondant aux exigences du déploiement automatique n’a été trouvée.',
    ],

    'api' => [
        'resource_not_found' => 'La ressource demandée n’existe pas sur ce serveur.',
    ],
];
