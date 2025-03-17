# GameXpress - REST API

## 📌 Project Overview
GameXpress is a RESTful API built with Laravel 11 and PHP 8.3, designed to manage products, categories, and users with role-based access control.

## 🚀 Features
- Admin authentication (register, login, logout)
- Role & permission management (Spatie)
- Product & category CRUD operations
- User management
- Email notifications for low stock
- API documentation (Postmane)

## 🛠️ Tech Stack
- **Framework:** Laravel 11
- **Authentication:** Laravel Sanctum
- **Permissions:** Spatie Permission
- **Database:** MySQL
- **Testing:** UnitTest

## 📌 API Endpoints (v1)
### 🔑 Authentication
- `POST /api/v1/admin/register` – Register admin
- `POST /api/v1/admin/login` – Login
- `POST /api/v1/admin/logout` – Logout

### 📊 Dashboard
- `GET /api/v1/admin/dashboard` – View statistics

### 🛍️ Product Management
- `GET /api/v1/admin/products` – List products
- `POST /api/v1/admin/products` – Create product
- `PUT /api/v1/admin/products/{id}` – Update product
- `DELETE /api/v1/admin/products/{id}` – Delete product

### 🗂️ Category Management
- `GET /api/v1/admin/categories` – List categories
- `POST /api/v1/admin/categories` – Create category
- `PUT /api/v1/admin/categories/{id}` – Update category
- `DELETE /api/v1/admin/categories/{id}` – Delete category

### 👥 User Management
- `GET /api/v1/admin/users` – List users
- `POST /api/v1/admin/users` – Create user
- `PUT /api/v1/admin/users/{id}` – Update user
- `DELETE /api/v1/admin/users/{id}` – Delete user

## 🔧 Setup & Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/nolongeraregistereduser/GameXpress.git
   ```
2. Install dependencies:
   ```bash
   cd GameXpress
   composer install
   ```
3. Set up `.env` file and configure database.
4. Run migrations:
   ```bash
   php artisan migrate --seed
   ```
5. Serve the application:
   ```bash
   php artisan serve
   ```

## 🧪 Testing
Run tests with:
```bash
php artisan test
```

## 📖 API Documentation
API documentation is available via Postman.

---
🚀 **Happy Coding!**

