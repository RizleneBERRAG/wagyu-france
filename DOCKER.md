# Wagyu France — environnement Docker local

Ce guide permet de lancer le projet sur Windows avec Docker Desktop, sans installer PHP, Composer, MySQL ou Node directement sur la machine.

## 1. Prérequis

- Git
- Docker Desktop avec le moteur WSL 2 activé
- Le fichier `.env` transmis de manière privée

Vérifier l’installation dans PowerShell :

```powershell
docker --version
docker compose version
git --version
```

## 2. Récupérer le projet

Première installation :

```powershell
git clone https://github.com/RizleneBERRAG/wagyu-france.git
cd wagyu-france
```

Projet déjà cloné :

```powershell
git checkout main
git pull origin main
```

## 3. Préparer le fichier `.env`

Le fichier `.env` doit se trouver à la racine, au même niveau que `compose.yaml`.

Conserver les informations légales et les identifiants administrateur, puis utiliser les valeurs Docker suivantes :

```env
APP_URL=http://localhost:8000
APP_PORT=8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=wagyu_france
DB_USERNAME=wagyu
DB_PASSWORD=wagyu_local
DB_ROOT_PASSWORD=root_local
FORWARD_DB_PORT=3307

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="contact@wagyufrance.fr"
MAIL_FROM_NAME="${APP_NAME}"
MAILPIT_PORT=8025

WF_ADMIN_NAME="Nom du propriétaire"
WF_ADMIN_EMAIL="adresse@email.fr"
WF_ADMIN_PASSWORD="un-mot-de-passe-long-et-unique"
```

Ne jamais pousser `.env` sur GitHub.

## 4. Construire et démarrer les conteneurs

```powershell
docker compose up -d --build
```

Le premier démarrage peut prendre plusieurs minutes : PHP, les extensions et Composer sont installés dans l’image.

Contrôler l’état :

```powershell
docker compose ps
```

Suivre les journaux de Laravel/PHP :

```powershell
docker compose logs -f app
```

Quitter l’affichage des journaux avec `Ctrl + C` sans arrêter le projet.

## 5. Initialiser Laravel

Lorsque le service `app` est démarré :

```powershell
docker compose exec app php artisan migrate

docker compose exec app php artisan optimize:clear
```

Le lien `public/storage` et la clé Laravel sont préparés automatiquement au démarrage si nécessaire.

## 6. Installer et compiler les ressources Node

```powershell
docker compose --profile tools run --rm node
```

Cette commande installe les dépendances npm dans un volume Docker puis lance `npm run build`.

## 7. Ouvrir les services

- Site : `http://localhost:8000`
- Administration : `http://localhost:8000/admin/login`
- Mailpit : `http://localhost:8025`
- MySQL depuis un logiciel local : `127.0.0.1:3307`

Dans Laravel, le serveur MySQL reste `mysql:3306`, car les conteneurs communiquent avec le nom du service.

## 8. Commandes quotidiennes

Démarrer :

```powershell
docker compose up -d
```

Arrêter sans supprimer les données :

```powershell
docker compose down
```

Voir les conteneurs :

```powershell
docker compose ps
```

Ouvrir un terminal dans Laravel :

```powershell
docker compose exec app sh
```

Lancer une commande Artisan :

```powershell
docker compose exec app php artisan route:list
```

Lancer les migrations :

```powershell
docker compose exec app php artisan migrate
```

Lancer les tests :

```powershell
docker compose exec app php artisan test
```

Lancer Pint :

```powershell
docker compose exec app ./vendor/bin/pint
```

Reconstruire après une modification du `Dockerfile` ou de `compose.yaml` :

```powershell
docker compose up -d --build
```

## 9. Mise à jour après un `git pull`

```powershell
git pull origin main
docker compose up -d --build
docker compose exec app php artisan migrate
docker compose exec app php artisan optimize:clear
docker compose --profile tools run --rm node
```

Le conteneur `app` exécute aussi `composer install` à son démarrage en utilisant `composer.lock`.

## 10. Emails locaux

Tous les emails SMTP locaux arrivent dans Mailpit :

```text
http://localhost:8025
```

Aucun email n’est envoyé à une vraie adresse tant que `MAIL_HOST=mailpit`.

## 11. Données et fichiers partagés

Chaque développeur possède sa propre base MySQL dans le volume Docker `mysql_data`.

Git ne partage pas :

- les clients et commandes créés localement ;
- les données de test ;
- les images téléversées dans `storage/app/public` ;
- les emails Mailpit ;
- le fichier `.env`.

Pour partager les mêmes données, il faut exporter/importer la base et copier séparément les fichiers de stockage utiles.

## 12. Réinitialisation complète

Arrêter seulement :

```powershell
docker compose down
```

Supprimer également la base MySQL, les dépendances Composer et npm contenues dans les volumes :

```powershell
docker compose down -v
```

Attention : `docker compose down -v` supprime définitivement les données locales Docker du projet.

Après une réinitialisation complète :

```powershell
docker compose up -d --build
docker compose exec app php artisan migrate
docker compose --profile tools run --rm node
```

## 13. Résolution des problèmes

### Le port 8000 est déjà utilisé

Modifier dans `.env` :

```env
APP_PORT=8080
```

Puis :

```powershell
docker compose up -d
```

Le site sera accessible sur `http://localhost:8080`.

### MySQL local utilise déjà le port 3307

Modifier :

```env
FORWARD_DB_PORT=3308
```

Le port interne Laravel reste toujours `DB_PORT=3306`.

### Erreur de connexion MySQL au premier démarrage

Attendre que le service devienne `healthy` :

```powershell
docker compose ps
docker compose logs mysql
```

Puis relancer :

```powershell
docker compose exec app php artisan migrate
```

### Laravel affiche une ancienne configuration

```powershell
docker compose exec app php artisan optimize:clear
```

### Repartir de l’image PHP sans supprimer la base

```powershell
docker compose build --no-cache app
docker compose up -d
```

## 14. Travail à plusieurs avec Git

Avant de commencer :

```powershell
git checkout main
git pull origin main
git checkout -b feature/nom-de-la-fonctionnalite
```

Après le travail :

```powershell
git add .
git commit -m "Description claire de la modification"
git push -u origin feature/nom-de-la-fonctionnalite
```

Créer ensuite une pull request vers `main`. Éviter de développer simultanément directement sur `main` réduit fortement les conflits.
