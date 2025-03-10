# 📦 API Administrateur E-commerce (GameXpress)

## 🚀 Introduction
Bienvenue dans l'API d'administration de **GameXpress**, une plateforme e-commerce développée avec **Laravel 11**. Cette API permet de gérer les produits, les catégories et les utilisateurs avec un système d'authentification sécurisé et une gestion des rôles avancée.

## 🛠️ Technologies Utilisées
- **Framework** : Laravel 11 & PHP 8.3
- **Authentification** : Laravel Sanctum
- **Gestion des rôles et permissions** : Spatie Permission
- **Tests** : Pest PHP / PHPUnit
- **Base de données** : MySQL
- **Documentation API** : Swagger/OpenAPI (optionnel)

## 📐 Architecture
L'API suit une architecture **RESTful** avec :
- 📌 **Versionnement** : `v1`
- ✅ **Structure de réponse cohérente**
- 🔐 **Authentification par token** (Sanctum)
- 🛡️ **Gestion des permissions** avec Spatie

## 🔗 Endpoints Principaux

### 🔑 1. Authentification Administrateur
- `POST /api/v1/admin/register` → Inscription
- `POST /api/v1/admin/login` → Connexion
- `POST /api/v1/admin/logout` → Déconnexion

### 📊 2. Tableau de Bord
- `GET /api/v1/admin/dashboard` → Statistiques
- Notifications email pour les stocks critiques

### 🛍️ 3. Gestion des Produits
- `GET /api/v1/admin/products` → Lister
- `GET /api/v1/admin/products/{id}` → Voir un produit
- `POST /api/v1/admin/products` → Ajouter
- `PUT /api/v1/admin/products/{id}` → Modifier
- `DELETE /api/v1/admin/products/{id}` → Supprimer

### 🗂️ 4. Gestion des Catégories
- `GET /api/v1/admin/categories` → Lister
- `POST /api/v1/admin/categories` → Ajouter
- `PUT /api/v1/admin/categories/{id}` → Modifier
- `DELETE /api/v1/admin/categories/{id}` → Supprimer

### 👥 5. Gestion des Utilisateurs
- `GET /api/v1/admin/users` → Lister
- `POST /api/v1/admin/users` → Ajouter
- `PUT /api/v1/admin/users/{id}` → Modifier
- `DELETE /api/v1/admin/users/{id}` → Supprimer

## 🗄️ Modèles de Données

### 👤 Utilisateur (`users`)
| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Identifiant unique |
| `name` | string | Nom |
| `email` | string | Adresse e-mail |
| `password` | string | Mot de passe |
| `timestamps` | timestamp | Dates création & mise à jour |

### 🏷️ Catégorie (`categories`)
| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Identifiant unique |
| `name` | string | Nom |
| `slug` | string | URL-friendly |
| `timestamps` | timestamp | Dates création & mise à jour |

### 🏷️ Produit (`products`)
| Champ | Type | Description |
|-------|------|-------------|
| `id` | int | Identifiant unique |
| `name` | string | Nom |
| `price` | decimal | Prix |
| `stock` | int | Quantité |
| `category_id` | int | Catégorie associée |
| `timestamps` | timestamp | Dates création & mise à jour |

## 🛡️ Gestion des Rôles et Permissions

### 🎭 Rôles
- `super_admin`
- `product_manager`
- `user_manager`

### 🔑 Permissions
- `view_dashboard`
- `view_products`, `create_products`, `edit_products`, `delete_products`
- `view_categories`, `create_categories`, `edit_categories`, `delete_categories`
- `view_users`, `create_users`, `edit_users`, `delete_users`

## 🧪 Plan de Tests
- ✅ Tests **unitaires** pour chaque endpoint
- ✅ Tests **de validation** des rôles et permissions
- ✅ Tests **de performance**

## 📂 Organisation du Code
```
📂 app
 ├── 📁 Http
 │   ├── 📂 Controllers
 │   │   └── 📂 Api/V1/Admin
 │   ├── 📂 Requests
 │   ├── 📂 Resources
 ├── 📁 Models
 ├── 📁 Middleware
 ├── 📂 routes
 │   ├── api.php
 ├── 📂 tests
 │   ├── Feature/Api/V1/Admin
```

 Finalisation des **tests et documentation API**

## 📤 Exporter les Endpoints
1. Ouvrez **Postman**
2. Sélectionnez la **collection** contenant vos endpoints
3. Cliquez sur les trois points **(...)** puis sur **Exporter**
4. Choisissez le format **JSON** et cliquez sur **Exporter**
5. Enregistrez le fichier pour le partager

---

## 📜 Licence
Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, de le modifier et de le distribuer.

## 📩 Contact
Si vous avez des questions ou souhaitez contribuer, n'hésitez pas à ouvrir une issue ou à me contacter ! 🚀

