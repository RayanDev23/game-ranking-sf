# Projet Symfony game-ranking-sf

Ce projet Symfony permet de gérer des jeux vidéo enregistrés dans une base de données. Les fonctionnalités principales comprennent l'ajout, la modification, l'affichage et la suppression de jeux.

## Installation

1. **Cloner le Projet :**
   ```bash
   git clone https://github.com/votre-utilisateur/jeux-classement-sf.git
   cd jeux-classement-sf


2. Installer les Dépendances

    ```bash
    composer install


## Configurer la Base de Données

1. Créer une base de données MySQL.

2. Creer le fichier .env.local et configurer la variable DATABASE_URL avec les informations de votre base de données.

## Appliquer les Migrations


1. ```bash
    php bin/console doctrine:migrations:migrate

## Lancer le Serveur de Développement

1.  ```bash
    php bin/console server:run


## Utilisation

- Accéder à l'application dans votre navigateur à l'adresse [http://127.0.0.1:8000](http://127.0.0.1:8000).

### Liste des Jeux

- La page d'accueil affiche une liste de jeux classés par ordre alphabétique du titre.

### Ajout ou Modification d'un Jeu

- Accéder à la page "Ajouter un Jeu" depuis le lien correspondant.
- Remplir le formulaire avec les informations du jeu.
- Uploader une image pour le jeu.
- Soumettre le formulaire pour ajouter ou modifier le jeu.

### Affichage d'un Jeu

- Accéder à la page "Voir le Jeu" depuis le lien correspondant.
- Affichage des détails du jeu.

### Suppression d'un Jeu

- Accéder à la page "Supprimer le Jeu" depuis le lien correspondant.
- Confirmer la suppression.
