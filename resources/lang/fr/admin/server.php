<?php

return [
    'exceptions' => [
        'no_new_default_allocation' => 'Vous tentez de supprimer l’allocation principale de ce serveur, mais aucune allocation de remplacement n’est disponible.',
        'marked_as_failed' => 'Ce serveur est marqué comme ayant échoué lors d’une installation précédente. Son statut ne peut pas être modifié dans cet état.',
        'skipping_install_script' => 'Ce serveur est configuré pour ignorer le script d’installation de son Egg. La réinstallation n’est pas disponible tant que ce paramètre n’est pas désactivé.',
        'bad_variable' => 'Une erreur de validation s’est produite avec la variable :name.',
        'daemon_exception' => 'Une exception s’est produite lors de la communication avec le daemon, entraînant un code de réponse HTTP/:code. Cette exception a été enregistrée. (ID de requête : :request_id)',
        'default_allocation_not_found' => 'L’allocation principale demandée est introuvable parmi les allocations de ce serveur.',
    ],
    'alerts' => [
        'startup_changed' => 'La configuration de démarrage de ce serveur a été mise à jour. Si le Nid ou l’Egg de ce serveur a été modifié, une réinstallation va maintenant être effectuée.',
        'server_deleted' => 'Le serveur a été supprimé du système avec succès.',
        'server_created' => 'Le serveur a été créé avec succès sur le panel. Veuillez laisser quelques minutes au daemon pour terminer son installation.',
        'build_updated' => 'La configuration des ressources de ce serveur a été mise à jour. Certaines modifications peuvent nécessiter un redémarrage pour être appliquées.',
        'suspension_toggled' => 'Le statut de suspension du serveur a été modifié en :status.',
        'rebuild_on_boot' => 'Ce serveur a été marqué comme nécessitant une reconstruction du conteneur Docker. Celle-ci sera effectuée au prochain démarrage du serveur.',
        'install_toggled' => 'Le statut d’installation de ce serveur a été modifié.',
        'server_reinstalled' => 'Ce serveur a été placé dans la file d’attente pour une réinstallation qui débute maintenant.',
        'details_updated' => 'Les détails du serveur ont été mis à jour avec succès.',
        'docker_image_updated' => 'L’image Docker par défaut de ce serveur a été modifiée avec succès. Un redémarrage est nécessaire pour appliquer cette modification.',
        'node_required' => 'Vous devez avoir au moins un nœud configuré avant de pouvoir ajouter un serveur à ce panel.',
        'transfer_nodes_required' => 'Vous devez avoir au moins deux nœuds configurés avant de pouvoir transférer des serveurs.',
        'transfer_started' => 'Le transfert du serveur a démarré.',
        'transfer_not_viable' => 'Le nœud sélectionné ne dispose pas de suffisamment d’espace disque ou de mémoire pour accueillir ce serveur.',
    ],
];
