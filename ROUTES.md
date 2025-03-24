### 📌 1. Afficher toutes les formations
**`GET /formations`**
#### 🔹 Description :
Affiche la liste complète des formations disponibles sur le site.

#### 🖥️ Vue associée :
`pages/formations.html.twig`

#### 🔹 Données transmises à la vue :
| Nom         | Type    | Description |
|------------|--------|-------------|
| `formations` | array  | Liste des formations récupérées depuis la base de données. |
| `categories` | array  | Liste des catégories de formation. |

---

### 📌 2. Trier les formations
**`GET /formations/tri/{champ}/{ordre}/{table}`**
#### 🔹 Description :
Trie les formations en fonction d'un champ et d'un ordre spécifiés.

#### 🔹 Paramètres :
| Nom   | Type   | Obligatoire | Description                        |
|-------|--------|------------|------------------------------------|
| `champ` | string | ✅ | Champ sur lequel trier (`titre`, `date`, etc.). |
| `ordre` | string | ✅ | Ordre (`ASC` ou `DESC`). |
| `table` | string | ❌ | Table optionnelle (utile si jointure). |

---

### 📌 3. Rechercher une formation
**`GET /formations/recherche/{champ}/{table}`**
#### 🔹 Description :
Effectue une recherche dynamique sur un champ spécifique.

#### 🔹 Paramètres :
| Nom   | Type   | Obligatoire | Description                        |
|-------|--------|------------|------------------------------------|
| `champ` | string | ✅ | Champ concerné (`titre`, `categorie`, etc.). |
| `table` | string | ❌ | Table concernée (optionnelle). |

---

### 📌 4. Afficher une formation spécifique
**`GET /formations/formation/{id}`**
#### 🔹 Description :
Affiche le détail d'une formation spécifique.

#### 🔹 Paramètres :
| Nom   | Type   | Obligatoire | Description |
|-------|--------|------------|-------------|
| `id`  | int    | ✅ | Identifiant unique de la formation. |

### 📌 5. Afficher toutes les playlists
**`GET /playlists`**
#### 🔹 Description :
Affiche la liste complète des playlists disponibles sur le site.

#### 🖥️ Vue associée :
`pages/playlists.html.twig`

#### 🔹 Données transmises à la vue :
| Nom         | Type    | Description |
|-------------|---------|-------------|
| `playlists` | array   | Liste des playlists récupérées depuis la base de données. |
| `categories`| array   | Liste des catégories associées. |

---

### 📌 6. Trier les playlists
**`GET /playlists/tri/{champ}/{ordre}`**
#### 🔹 Description :
Trie les playlists en fonction d'un champ et d'un ordre spécifiés.

#### 🔹 Paramètres :
| Nom     | Type    | Obligatoire | Description                          |
|---------|---------|-------------|--------------------------------------|
| `champ` | string  | ✅          | Champ sur lequel trier (`name`, `nbFormations`). |
| `ordre` | string  | ✅          | Ordre (`ASC` ou `DESC`).             |

---

### 📌 7. Rechercher une playlist
**`GET /playlists/recherche/{champ}/{table}`**
#### 🔹 Description :
Effectue une recherche dynamique sur un champ spécifique.

#### 🔹 Paramètres :
| Nom     | Type    | Obligatoire | Description                          |
|---------|---------|-------------|--------------------------------------|
| `champ` | string  | ✅          | Champ concerné (`name`, `categorie`, etc.). |
| `table` | string  | ❌          | Table concernée (optionnelle).       |

---

### 📌 8. Afficher une playlist spécifique
**`GET /playlists/playlist/{id}`**
#### 🔹 Description :
Affiche le détail d'une playlist spécifique.

#### 🔹 Paramètres :
| Nom   | Type  | Obligatoire | Description                          |
|-------|-------|-------------|--------------------------------------|
| `id`  | int   | ✅          | Identifiant unique de la playlist.   |

---

### 📌 9. Afficher toutes les formations
**`GET /formations`**
#### 🔹 Description :
Affiche la liste complète des formations disponibles sur le site.

#### 🖥️ Vue associée :
`pages/formations.html.twig`

#### 🔹 Données transmises à la vue :
| Nom         | Type    | Description |
|-------------|---------|-------------|
| `formations`| array   | Liste des formations récupérées depuis la base de données. |
| `categories`| array   | Liste des catégories associées. |

---

### 📌 10. Trier les formations
**`GET /formations/tri/{champ}/{ordre}/{table}`**
#### 🔹 Description :
Trie les formations en fonction d'un champ et d'un ordre spécifiés.

#### 🔹 Paramètres :
| Nom     | Type    | Obligatoire | Description                          |
|---------|---------|-------------|--------------------------------------|
| `champ` | string  | ✅          | Champ sur lequel trier (`titre`, `date`, etc.). |
| `ordre` | string  | ✅          | Ordre (`ASC` ou `DESC`).             |
| `table` | string  | ❌          | Table optionnelle (utile si jointure). |

---

### 📌 11. Rechercher une formation
**`GET /formations/recherche/{champ}/{table}`**
#### 🔹 Description :
Effectue une recherche dynamique sur un champ spécifique.

#### 🔹 Paramètres :
| Nom     | Type    | Obligatoire | Description                          |
|---------|---------|-------------|--------------------------------------|
| `champ` | string  | ✅          | Champ concerné (`titre`, `categorie`, etc.). |
| `table` | string  | ❌          | Table concernée (optionnelle).       |

---

### 📌 12. Afficher une formation spécifique
**`GET /formations/formation/{id}`**
#### 🔹 Description :
Affiche le détail d'une formation spécifique.

#### 🔹 Paramètres :
| Nom   | Type  | Obligatoire | Description                          |
|-------|-------|-------------|--------------------------------------|
| `id`  | int   | ✅          | Identifiant unique de la formation.  |

---

### 📌 13. Afficher toutes les catégories
**`GET /admin/categories`**
#### 🔹 Description :
Affiche la liste complète des catégories disponibles dans l'administration.

#### 🖥️ Vue associée :
`admin/admin.categories.html.twig`

#### 🔹 Données transmises à la vue :
| Nom         | Type    | Description |
|-------------|---------|-------------|
| `categories`| array   | Liste des catégories récupérées depuis la base de données. |
| `form`      | Form    | Formulaire pour ajouter une nouvelle catégorie. |

---

### 📌 14. Supprimer une catégorie
**`GET /admin/categories/{id}/delete`**
#### 🔹 Description :
Supprime une catégorie spécifique.

#### 🔹 Paramètres :
| Nom   | Type  | Obligatoire | Description                          |
|-------|-------|-------------|--------------------------------------|
| `id`  | int   | ✅          | Identifiant unique de la catégorie.  |

---

### 📌 15. Créer une catégorie
**`GET /admin/categorie/create`**
#### 🔹 Description :
Affiche un formulaire pour créer une nouvelle catégorie.

#### 🖥️ Vue associée :
`admin/_categorie/form.categorie.html.twig`

#### 🔹 Données transmises à la vue :
| Nom   | Type  | Description                          |
|-------|-------|--------------------------------------|
| `form`| Form  | Formulaire pour créer une nouvelle catégorie. |

---

### 📌 16. Afficher toutes les formations (Admin)
**`GET /admin/formations`**
#### 🔹 Description :
Affiche la liste complète des formations dans l'administration.

#### 🖥️ Vue associée :
`admin/admin.formations.html.twig`

#### 🔹 Données transmises à la vue :
| Nom         | Type    | Description |
|-------------|---------|-------------|
| `formations`| array   | Liste des formations récupérées depuis la base de données. |
| `categories`| array   | Liste des catégories associées. |

---

### 📌 17. Créer une formation (Admin)
**`GET /admin/formations/create`**
#### 🔹 Description :
Affiche un formulaire pour créer une nouvelle formation.

#### 🖥️ Vue associée :
`admin/_formation/form.formation.html.twig`

#### 🔹 Données transmises à la vue :
| Nom   | Type  | Description                          |
|-------|-------|--------------------------------------|
| `form`| Form  | Formulaire pour créer une nouvelle formation. |

---

### 📌 18. Modifier une formation (Admin)
**`GET /admin/formations/{id}/edit`**
#### 🔹 Description :
Affiche un formulaire pour modifier une formation existante.

#### 🔹 Paramètres :
| Nom   | Type  | Obligatoire | Description                          |
|-------|-------|-------------|--------------------------------------|
| `id`  | int   | ✅          | Identifiant unique de la formation.  |

#### 🖥️ Vue associée :
`admin/_formation/form.formation.html.twig`

#### 🔹 Données transmises à la vue :
| Nom   | Type  | Description                          |
|-------|-------|--------------------------------------|
| `form`| Form  | Formulaire pour modifier une formation. |

---

### 📌 19. Supprimer une formation (Admin)
**`GET /admin/formations/{id}/delete`**
#### 🔹 Description :
Supprime une formation spécifique.

#### 🔹 Paramètres :
| Nom   | Type  | Obligatoire | Description                          |
|-------|-------|-------------|--------------------------------------|
| `id`  | int   | ✅          | Identifiant unique de la formation.  |
