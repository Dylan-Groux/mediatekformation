# MediatekFormation

## Lien vers le dépôt d'origine

Le dépôt d'origine de l'application est disponible ici : **[https://github.com/CNED-SLAM/mediatekformation](#)**.  
Il contient, dans son README, la présentation de l'application d'origine.

---

## Présentation

Ce site, développé avec **Symfony 6.4**, permet d'accéder aux vidéos d'auto-formation proposées par une chaîne de médiathèques et accessibles sur **YouTube**.  
Cette version intègre plusieurs nouvelles fonctionnalités et améliorations par rapport à la version originale.

**URL du site en ligne** : [https://mediatekformation.grdy2507.odns.fr/]

---

## Fonctionnalités ajoutées

### Nettoyage du code
- Refactoring du code pour une meilleure lisibilité et maintenance.

### Ajout d'une nouvelle fonctionnalité
- **Exemple** : Ajout d'un système de recherche avancée pour les vidéos.

### Gestion des formations
- Possibilité d'ajouter, modifier et supprimer des formations depuis un back-office.

### Gestion des playlists
- Création, modification et suppression de playlists administrables.

### Gestion des catégories
- Administration des catégories pour mieux organiser les formations.

### Système d'authentification
- Accès restreint à l'administration avec authentification utilisateur.

### Gestion des tests
- Implémentation de tests unitaires et fonctionnels pour assurer la stabilité de l'application.

### Documentation technique
- Rédaction d'une documentation détaillée pour faciliter la maintenance et l'évolution du projet.

### Déploiement du site
- Mise en ligne et configuration sur un serveur distant.

---

## Entités principales de l'application

### Formation
- **Champs** : titre, description, durée, lien vidéo, catégorie.
- **Relations** : appartient à une catégorie, peut être associée à plusieurs playlists.

### Playlist
- **Champs** : nom, description, liste de formations.
- **Relations** : contient plusieurs formations.

### Catégorie
- **Champs** : nom, description.
- **Relations** : regroupe plusieurs formations.

### Utilisateur (Admin)
- **Champs** : nom d'utilisateur, email, mot de passe, rôle.
- **Fonctionnalités** : accès au back-office pour gérer les formations, playlists et catégories.

---

## Installation et utilisation en local

### Prérequis

Avant d'installer l'application, assurez-vous d'avoir installé :
- **PHP 8.2+**
- **Composer**
- **Git**
- **Wampserver/Xampp** ou un serveur équivalent
- **MySQL**

### Installation

1. **Cloner le projet**  
    ```bash
    git clone URL_DU_DEPOT
    ```
    Placer le projet dans le dossier `www` de Wampserver ou un dossier équivalent.

2. **Installer les dépendances**  
    ```bash
    cd mediatekformation
    composer install
    ```

3. **Configurer la base de données**  
    - Se connecter à **phpMyAdmin**.
    - Créer une base de données `mediatekformation`.
    - Importer le fichier `mediatekformation.sql` (disponible à la racine du projet).
    - Configurer le fichier `.env` avec les informations de connexion MySQL.

4. **Démarrer le serveur Symfony**  
    ```bash
    symfony server:start
    ```
    ou avec PHP :  
    ```bash
    php -S localhost:8000 -t public
    ```

5. **Accéder à l'application**  
    Ouvrir [http://localhost:8000](http://localhost:8000) dans le navigateur.

---

## Test de l'application en ligne

L'application est déployée à l'adresse : [https://mediatekformation.grdy2507.odns.fr/playlists](https://mediatekformation.grdy2507.odns.fr/playlists)

**Remarque** : Les informations d'authentification pour accéder à l'administration ne sont pas communiquées ici pour des raisons de sécurité. Elles seront fournies dans un document séparé.

---

## Contributions

Les contributions sont les bienvenues ! Pour proposer une modification :
1. **Forker le dépôt**.
2. **Créer une branche feature**.
3. **Faire une pull request** avec une description claire des changements.

---

## Licence

Ce projet est sous licence **[Nom de la licence, ex: MIT, GPL, etc.]**.