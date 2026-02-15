# projet_NFE114
Projet pour NFE114

# Installation
1. Cloner le dépôt : `git clone`
2. Remplacer les fichiers d'environnement : `cp .env.example .env && cp .db.env.example .db.env`
3. Lancer le projet : `docker-compose up -d`
4. Accéder à l'application : `http://localhost:8080`

## Attention au composer
Une fois lancé, accedez au conteneur : `docker exec -it <container_id> bash`
Puis installer les dépendances : `composer install`

# Technologies utilisées
- PHP 8.2
- MYSQL
- Docker
- JavaScript
- HTML/CSS
- JWT pour l'authentification

# Structure du projet
- `src/` : Contient le code source de l'application
- `src/public/` : Contient les fichiers accessibles publiquement
- `src/api/` : L'api pour les requetes AJAX
- `src/config/` : Contient les fichiers de configuration
- `src/controllers/` : Contient les contrôleurs de l'application
- `src/models/` : Contient les modèles de données
- `src/views/` : Contient les vues de l'application
- `docker-compose.yml` : Fichier de configuration pour Docker
- `docker/apache/000-default.conf` : Configuration d'Apache pour le projet
- `docker/php/Dockerfile` : Dockerfile pour l'image PHP utilisée dans le projet
- `db/init.sql` : Script SQL pour initialiser la base de données
- `.env.example` : Exemple de fichier d'environnement pour la configuration de la base de données et d'autres variables d'environnement
- `.db.env.example` : Exemple de fichier d'environnement pour la configuration de la base de données

# Fonctionnalités
- Les adherents peuvent s'inscrire et se connecter à leur compte
- Les adherents peuvent consulter et réserver des cours
- Les coachs peuvent voir leurs cours
- Les administrateurs peuvent voir les statistiques et les prix des coachs