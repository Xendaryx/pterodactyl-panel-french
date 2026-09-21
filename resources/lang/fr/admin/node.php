<?php

return [
    'validation' => [
        'fqdn_not_resolvable' => 'Le FQDN ou l’adresse IP fourni ne correspond pas à une adresse IP valide.',
        'fqdn_required_for_ssl' => 'Un nom de domaine complet (FQDN) résolvant vers une adresse IP publique est requis pour utiliser SSL sur ce nœud.',
    ],
    'notices' => [
        'allocations_added' => 'Les allocations ont été ajoutées avec succès à ce nœud.',
        'node_deleted' => 'Le nœud a été supprimé du panel avec succès.',
        'location_required' => 'Vous devez configurer au moins un emplacement avant de pouvoir ajouter un nœud à ce panel.',
        'node_created' => 'Le nouveau nœud a été créé avec succès. Vous pouvez configurer automatiquement le daemon sur cette machine depuis l\'onglet \'Configuration\'. Avant de pouvoir ajouter des serveurs, vous devez d\'abord attribuer au moins une adresse IP et un port.',
        'node_updated' => 'Les informations du nœud ont été mises à jour. Si des paramètres du daemon ont été modifiés, vous devrez le redémarrer pour que ces changements prennent effet.',
        'unallocated_deleted' => 'Tous les ports non attribués pour <code>:ip</code> ont été supprimés.',
    ],
];
