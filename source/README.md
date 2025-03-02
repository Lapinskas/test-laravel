# Lendflow Laravel Assessment - code overview
The Laravel assessment task completed by **Vladas Lapinskas** in **March 2025**.

Please refer to the [main project page](https://github.com/Lapinskas/test-laravel/blob/main/README.md) for local setup and CI/CD


## 📌 Project Overview

This project is a **Laravel JSON API** that acts as an intermediary between clients and the **New York Times Best Sellers History API**. The API allows filtering bestsellers by author, ISBN, book title, and paginating results with an offset (20 results per page).

The project is built following best practices for API integration, including **versioning, caching, error handling, testing without external dependencies, and code reusability**.

## 🚀 API Functionality

- **Fetch data from the NYT API**: Implements an endpoint to retrieve bestseller information.  
- **Supports filtering** by `author`, `isbn[]`, `title`, and `offset`.  
- **Strict parameter validation**: Enforces stricter validation rules than the # Структура кода в `source/app`

## 📁 Code Structure of the App

The code structure reflects a professional Laravel development approach, emphasizing modularity, separation of concerns, and testability. The absence of models is justified by the project’s focus as an API wrapper. The use of services and repositories with dependency injection ensures a scalable codebase.
- Code structure is detailed in the dedicated document [CODE-STRUCTURE.md](https://github.com/Lapinskas/test-laravel/blob/main/source/CODE-STRUCTURE.md)

The code pass quality checks thanks to integrated GitHub Actions CI/CD on every commit.
The pipeline combination of `Pint`, `PHPStan`, `PHP Insights` and `Pest` ensures high code quality and maintainability.
- Code quality tools are explained at the [main project page](https://github.com/Lapinskas/test-laravel/blob/main/README.md)
