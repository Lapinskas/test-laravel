# Lendflow Laravel Assessment

This repository contains the Laravel assessment task completed by **Vladas Lapinskas** in **March 2025**.

It includes:
- The [Docker configuration](https://github.com/Lapinskas/test-laravel/blob/main/docker-compose.yml)
- The [Laravel source code](https://github.com/Lapinskas/test-laravel/blob/main/source/README.md)

For detailed information on the Laravel implementation, refer to the [Laravel project README](https://github.com/Lapinskas/test-laravel/blob/main/source/README.md).

## 🚀 Docker Setup
The project is containerized using Docker with a **standard Laravel environment**:
- **NGINX** as the web server
- **PHP** with required extensions
- **Redis** for caching
- **MySQL** (currently unused but available for future expansion)

## 🛠 Getting Started
Follow these steps to set up the project locally:

### 1️⃣ Clone the repository:
```sh
git clone git@github.com:Lapinskas/test-laravel.git
```

### 2️⃣ Build the Docker containers:
```sh
docker compose build
```

### 3️⃣ Start the Docker stack:
```sh
docker compose up -d
```

### 4️⃣ Verify that four containers are running:
```sh
docker ps --format "{{.Names}} - {{.Status}}"
```
You should see output similar to:
```sh
nyt-nginx-fpm - Up 16 minutes
nyt-php - Up 16 minutes
nyt-redis - Up 16 minutes
nyt-database - Up 16 minutes (healthy)
```
### 5️⃣ Environment variables

To set up the .env file, follow these steps:

Copy the .env.example file to .env:
```sh
cp source/.env.example source/.env
```
Add values for the NYT API keys in your .env file:
```
NYT_API_APP_ID=your_app_id_here
NYT_API_KEY=your_api_key_here
NYT_API_SECRET=  // not used in the project
```

### 6️⃣ Composer

Generate APP KEY by running following command in your docker container
```sh
php artisan key:generate
```

Intall project dependencies
```sh
composer install
```


## 🌍 Homepage & API Documentation
The project's homepage is accessible at [http://localhost](http://localhost). It includes a link to the [**Swagger documentation**](http://localhost/api/documentation), which allows you to test API endpoints using Swagger UI, Postman, curl, or any other API testing tool.

## ✅ Code Quality & CI/CD Pipeline
The project integrates **GitHub Actions CI/CD** for automated **code quality checks** and **tests** on every commit. The pipeline includes:
- ✅ **Laravel Pint** for code formatting
- 🔍 **PHPStan** for static analysis
- 📊 **PHP Insights** for code quality analysis
- 🧪 **Pest** for testing

This combination ensures **high code quality and maintainability**.

### 🔎 Code Quality Tools
#### 📊 PHP Insights
Performs static code analysis, evaluates code architecture, and measures complexity.
Run:
```sh
composer insights
```

#### 🔍 PHPStan
Detects potential errors in the code before testing.
Run:
```sh
composer stan
```

#### ✨ Laravel Pint
Applies consistent code formatting.
Run:
```sh
composer format
```

#### 🧪 Pest Tests
Ensures 100% test coverage for code reliability.
Run:
```sh
composer test
```

### 🔄 Pre-Merge Validation
A custom Composer script is available to validate the codebase before pushing changes. Run:
```sh
composer quality
```
This script runs:
1. ✅ Laravel Pint (code formatting)
2. 🔍 PHPStan (static analysis)
3. 📊 PHP Insights (code quality assessment)
4. 🧪 Pest Tests (unit and feature tests)

By following these steps, we maintain **a clean, efficient, and well-tested codebase**. 🚀

