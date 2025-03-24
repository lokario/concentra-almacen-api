# Concentra Almacén API

This is a RESTful API built with **Laravel** and **SQLite** for managing an inventory and billing system. The project is structured using clean architecture principles, Laravel conventions, and SOLID design patterns, with authentication, authorization, filtering, pagination, and full test coverage.

---

## Features

- User authentication and role-based access (admin/user)
- CRUD operations for:
  - Artículos
  - Clientes
  - Colocaciones
  - Pedidos
  - Facturas
- Filtering and pagination with metadata
- Form request validation with custom messages
- Test coverage for models and endpoints
- Seeders with relational sample data
- Postman collection included for testing

---

## Technologies

- Laravel 9
- PHP 8.0
- SQLite
- PHPUnit
- Laravel Sanctum

---

## Setup Instructions

### 1. Install dependencies

```bash
composer install
```

### 2. Environment setup

Copy the example file and create the database:

```bash
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
```

Make sure `.env` has:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/your/project/concentra-almacen-api/database/database.sqlite
```

### 3. Run migrations and seeders

```bash
php artisan migrate:fresh --seed
```

### 4. Run tests

```bash
php artisan test
```

### 5. Start server

```bash
php artisan serve
```

API will be available at `http://127.0.0.1:8000`

---

## Postman Collection

A full Postman collection is included in the project root:

```
postman/Concentra Almacén.postman_collection.json
```

You must log in and set the Bearer token as a collection variable before using the protected endpoints.