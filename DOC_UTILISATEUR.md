# 📌 Documentation Utilisateur

## 1. Page d'accueil
**Fichier** : `accueil.html.twig`  
**Description** :  
Affiche la page d'accueil du site avec une introduction et les deux dernières formations ajoutées.

### 🔹 Fonctionnalités :
- Présentation du site et de ses fonctionnalités.
- Affichage des deux dernières formations ajoutées avec leur miniature, titre, date de publication, et playlist associée.
- Liens vers les sections Formations et Playlists.

---

## 2. Liste des formations
**Fichier** : `formations.html.twig`  
**Description** :  
Affiche la liste complète des formations disponibles sur le site.

### 🔹 Fonctionnalités :
- Tri des formations par titre, playlist, catégorie ou date.
- Recherche dynamique par titre, playlist ou catégorie.
- Affichage des informations principales : titre, playlist associée, catégories, date de publication, et miniature.
- Lien vers le détail de chaque formation.

---

## 3. Détail d'une formation
**Fichier** : `formation.html.twig`  
**Description** :  
Affiche les détails d'une formation spécifique.

### 🔹 Fonctionnalités :
- Lecture de la vidéo associée via un lecteur YouTube intégré.
- Affichage des informations détaillées : titre, date de publication, playlist associée, catégories, et description.

---

## 4. Liste des playlists
**Fichier** : `playlists.html.twig`  
**Description** :  
Affiche la liste complète des playlists disponibles sur le site.

### 🔹 Fonctionnalités :
- Tri des playlists par nom ou nombre de formations.
- Recherche dynamique par nom ou catégorie.
- Affichage des informations principales : nom, catégories associées, et nombre de formations.
- Lien vers le détail de chaque playlist.

---

## 5. Détail d'une playlist
**Fichier** : `playlist.html.twig`  
**Description** :  
Affiche les détails d'une playlist spécifique.

### 🔹 Fonctionnalités :
- Affichage des informations principales : nom, description, et catégories associées.
- Liste des formations associées avec leur miniature et titre.
- Lien vers le détail de chaque formation.

---

## 6. Connexion
**Fichier** : `login/index.html.twig`  
**Description** :  
Affiche le formulaire de connexion pour les utilisateurs.

### 🔹 Fonctionnalités :
- Saisie de l'adresse e-mail et du mot de passe.
- Gestion des erreurs de connexion.
- Redirection après connexion réussie.

---

## 7. Inscription
**Fichier** : `signin/index.html.twig`  
**Description** :  
Affiche le formulaire d'inscription pour les nouveaux utilisateurs.

### 🔹 Fonctionnalités :
- Saisie des informations nécessaires pour créer un compte.
- Validation des données saisies.

---

## 8. Administration - Liste des formations
**Fichier** : `admin.formations.html.twig`  
**Description** :  
Affiche la liste des formations dans l'interface d'administration.

### 🔹 Fonctionnalités :
- Tri des formations par titre, playlist, catégorie ou date.
- Recherche dynamique par titre, playlist ou catégorie.
- Affichage des informations principales : titre, playlist associée, catégories, date de publication, et miniature.
- Boutons pour modifier ou supprimer une formation.
- Lien pour ajouter une nouvelle formation.

---

## 9. Administration - Formulaire de formation
**Fichier** : `form.formation.html.twig`  
**Description** :  
Affiche le formulaire pour créer ou modifier une formation.

### 🔹 Fonctionnalités :
- Saisie des informations principales : titre, description, vidéo, date de publication, playlist, et catégories.
- Validation des données saisies.
- Boutons pour enregistrer ou annuler les modifications.

---

## 10. Administration - Liste des playlists
**Fichier** : `admin.playlists.html.twig`  
**Description** :  
Affiche la liste des playlists dans l'interface d'administration.

### 🔹 Fonctionnalités :
- Tri des playlists par nom ou nombre de formations.
- Recherche dynamique par nom ou catégorie.
- Affichage des informations principales : nom, catégories associées, et nombre de formations.
- Boutons pour modifier ou supprimer une playlist.
- Lien pour ajouter une nouvelle playlist.

---

## 11. Administration - Formulaire de playlist
**Fichier** : `form.playlist.html.twig`  
**Description** :  
Affiche le formulaire pour créer ou modifier une playlist.

### 🔹 Fonctionnalités :
- Saisie des informations principales : nom, description, et formations associées.
- Validation des données saisies.
- Boutons pour enregistrer ou annuler les modifications.

---

## 12. Administration - Liste des catégories
**Fichier** : `admin.categories.html.twig`  
**Description** :  
Affiche la liste des catégories dans l'interface d'administration.

### 🔹 Fonctionnalités :
- Affichage des catégories disponibles.
- Bouton pour supprimer une catégorie.
- Inclusion du formulaire pour ajouter une nouvelle catégorie.

---

## 13. Administration - Formulaire de catégorie
**Fichier** : `form.categorie.html.twig`  
**Description** :  
Affiche le formulaire pour créer ou modifier une catégorie.

### 🔹 Fonctionnalités :
- Saisie du nom de la catégorie.
- Validation des données saisies.
- Boutons pour enregistrer ou annuler les modifications.

---

## 14. Mentions légales
**Fichier** : `cgu.html.twig`  
**Description** :  
Affiche les mentions légales du site.

### 🔹 Fonctionnalités :
- Informations sur l'éditeur, l'hébergeur, et les utilisateurs.
- Politique de confidentialité et accessibilité.
- Coordonnées de contact.
