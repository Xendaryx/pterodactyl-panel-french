============================================================
 TRADUCTION FRANÇAISE POUR PTERODACTYL PANEL 1.15.1
============================================================

Traduction française non officielle.

COMPATIBILITÉ
-------------

Ce pack est prévu pour :

Pterodactyl Panel 1.15.1

Il est déconseillé de l'installer directement sur une autre version sans
vérifier auparavant les différences entre les fichiers.

IMPORTANT
---------

Effectuez obligatoirement une sauvegarde de votre Panel avant installation.

Ce pack remplace certains fichiers PHP, Blade et TypeScript/React de
Pterodactyl afin de traduire également les textes qui ne sont pas gérés
par les fichiers de langue standards.

Une mise à jour de Pterodactyl pourra donc remplacer une partie de cette
traduction.

============================================================
 1. SAUVEGARDE
============================================================

Placez-vous dans le dossier de votre Panel.

Exemple :

cd /var/www/pterodactyl

Créez une sauvegarde avant toute modification.

Exemple :

sudo tar -czf /var/backups/pterodactyl-before-fr.tar.gz \
    /var/www/pterodactyl

Adaptez les chemins à votre installation.

============================================================
 2. COPIE DU PACK
============================================================

Décompressez Pterodactyl-1.15.1-FR.zip dans un dossier temporaire.

Copiez ensuite les dossiers suivants dans la racine de votre Panel :

app/
resources/

Les fichiers du pack doivent fusionner avec les dossiers existants.

NE SUPPRIMEZ PAS les autres fichiers de votre installation Pterodactyl.

============================================================
 3. LANGUE DU PANEL
============================================================

Vérifiez votre fichier .env.

La langue doit être configurée sur français si votre installation utilise
la variable APP_LOCALE :

APP_LOCALE=fr

Ne partagez jamais votre fichier .env.

============================================================
 4. DÉPENDANCES FRONTEND
============================================================

La traduction modifie également des fichiers TypeScript/React.

Node.js et Yarn doivent donc être disponibles.

Depuis la racine de Pterodactyl :

cd /var/www/pterodactyl

Si node_modules n'est pas présent, installez les dépendances conformément
à l'environnement de compilation de votre installation Pterodactyl.

Puis vérifiez TypeScript :

yarn tsc

============================================================
 5. COMPILATION
============================================================

Compilez les fichiers frontend :

yarn build:production

La compilation doit se terminer sans erreur.

Des avertissements concernant Browserslist, caniuse-lite, Tailwind ou
certaines dépréciations Node peuvent apparaître sans faire échouer la
compilation.

============================================================
 6. NETTOYAGE DU CACHE
============================================================

Depuis la racine du Panel :

php artisan optimize:clear

Si votre installation utilise www-data pour exécuter le Panel, adaptez
les commandes et permissions à votre environnement.

============================================================
 7. VÉRIFICATION
============================================================

Rechargez complètement votre navigateur.

Vous pouvez utiliser :

Ctrl + F5

Vérifiez notamment :

- connexion ;
- tableau de bord ;
- compte utilisateur ;
- administration ;
- serveurs ;
- utilisateurs ;
- nœuds ;
- emplacements ;
- bases de données ;
- paramètres ;
- e-mails ;
- Eggs et Nests ;
- console ;
- fichiers ;
- réseau ;
- sauvegardes ;
- planifications ;
- activité.

============================================================
 8. RETOUR EN ARRIÈRE
============================================================

En cas de problème :

1. restaurez les fichiers sauvegardés avant l'installation ;
2. recompilez le frontend si nécessaire :

yarn build:production

3. nettoyez le cache Laravel :

php artisan optimize:clear

============================================================
 AVERTISSEMENT
============================================================

Ce pack est une traduction non officielle.

Il ne remplace pas Pterodactyl et ne contient pas le Panel complet.

Pterodactyl reste soumis à sa licence et aux droits de ses auteurs.

Conservez toujours une sauvegarde avant de mettre à jour Pterodactyl ou
d'installer une nouvelle version de ce pack.
