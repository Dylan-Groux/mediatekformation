# 📌 Entités

## 1. Entité User
**Description :**  
Représente un utilisateur de l'application, utilisé pour l'authentification et la gestion des rôles.

### 🔹 Propriétés principales :
| Nom       | Type   | Description                                |
|-----------|--------|--------------------------------------------|
| `id`      | int    | Identifiant unique de l'utilisateur.       |
| `email`   | string | Adresse e-mail de l'utilisateur (unique).  |
| `roles`   | array  | Liste des rôles attribués à l'utilisateur. |
| `password`| string | Mot de passe haché de l'utilisateur.       |

### 🔹 Méthodes importantes :
| Nom                  | Description                                                                 |
|-----------------------|-----------------------------------------------------------------------------|
| `getUserIdentifier()`| Retourne l'identifiant unique de l'utilisateur (utilisé pour l'authentification). |
| `getRoles()`         | Retourne les rôles de l'utilisateur, avec au moins `ROLE_USER` par défaut.  |
| `eraseCredentials()` | Efface les données sensibles temporaires de l'utilisateur.                 |

---

## 2. Entité Playlist
**Description :**  
Représente une playlist contenant des formations et des catégories associées.

### 🔹 Propriétés principales :
| Nom            | Type   | Description                                      |
|-----------------|--------|--------------------------------------------------|
| `id`           | int    | Identifiant unique de la playlist.               |
| `name`         | string | Nom de la playlist.                              |
| `description`  | string | Description de la playlist.                      |
| `nbFormations` | int    | Nombre de formations associées à la playlist.    |

### 🔹 Méthodes importantes :
| Nom               | Description                                           |
|--------------------|-------------------------------------------------------|
| `getCategories()` | Retourne les catégories associées à la playlist.      |
| `getFormations()` | Retourne les formations associées à la playlist.      |
| `setNbFormations()`| Définit le nombre de formations associées à la playlist. |

---

## 3. Entité Formation
**Description :**  
Représente une formation, avec des informations comme le titre, la description, et les catégories associées.

### 🔹 Propriétés principales :
| Nom            | Type      | Description                                   |
|-----------------|-----------|-----------------------------------------------|
| `id`           | int       | Identifiant unique de la formation.           |
| `publishedAt`  | DateTime  | Date de publication de la formation.          |
| `title`        | string    | Titre de la formation.                        |
| `description`  | string    | Description de la formation.                  |
| `videoId`      | string    | Identifiant vidéo (YouTube).                  |

### 🔹 Méthodes importantes :
| Nom                     | Description                                      |
|--------------------------|--------------------------------------------------|
| `getMiniature()`        | Retourne l'URL de la miniature de la vidéo associée. |
| `getPicture()`          | Retourne l'URL de l'image de haute qualité de la vidéo associée. |
| `getCategories()`       | Retourne les catégories associées à la formation. |
| `getPublishedAtString()`| Retourne la date de publication au format `d/m/Y`. |

---

## 4. Entité Categorie
**Description :**  
Représente une catégorie, utilisée pour regrouper des formations et des playlists.

### 🔹 Propriétés principales :
| Nom   | Type   | Description                          |
|-------|--------|--------------------------------------|
| `id`  | int    | Identifiant unique de la catégorie.  |
| `name`| string | Nom de la catégorie.                |

### 🔹 Méthodes importantes :
| Nom               | Description                                      |
|--------------------|--------------------------------------------------|
| `getPlaylists()`  | Retourne les playlists associées à la catégorie. |
| `getFormations()` | Retourne les formations associées à la catégorie.|
