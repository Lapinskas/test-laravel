# Lendflow Laravel Assessment - code overview
The Laravel assessment task completed by **Vladas Lapinskas** in **March 2025**.

Please refer to the [main project page](https://github.com/Lapinskas/test-laravel/blob/main/README.md) for local setup and CI/CD


## 📌 Project Overview

This project is a **Laravel JSON API** that acts as an intermediary between clients and the **New York Times Best Sellers History API**. The API allows filtering bestsellers by author, ISBN, book title, and paginating results with an offset (20 results per page).

The project is built following best practices for API integration, including **versioning, caching, error handling, testing without external dependencies, and code reusability**.

## 🚀 API Functionality

- Fetch data from the NYT API: Implements an endpoint to retrieve bestseller information.
- Supports filtering by author, isbn[], title, and offset.
- Strict parameter validation (stricter than NYT).
- Handles errors and edge cases, including invalid requests and NYT API failures.
- Implements request caching to optimize performance.
- Logs requests and errors for monitoring and debugging.
- Ensures API versioning for future updates without breaking backward compatibility.

### General approach for API wrapper

- The response always includes a `success` flag, indicating either a successful operation or an error, whether on the wrapper's side or the NYT API side.
- The results retrieved from the NYT API are passed as-is in the `rawResponse` field, as there are no clear requirements for processing them.
- The `rawResponse` contains raw response for both successful and error responses from the NYT API.
- On a successful response, results are cached in Redis and served for the same filtering and pagination parameters without re-querying the NYT API.
- The `cached` flag indicates whether the results were retrieved from the cache or directly from the NYT API.
- If the NYT API returns an error, the wrapper propagates the same error code in its response.
- For internal wrapper errors, a `500 Internal Server Error` is returned, and the `rawResponse` field is omitted.


## 📁 Code Structure of the App

The code structure reflects a professional Laravel development approach, emphasizing modularity, separation of concerns, and testability. The absence of models is justified by the project’s focus as an API wrapper. The use of services and repositories with dependency injection ensures a scalable codebase.
- Code structure is detailed in the dedicated document [CODE-STRUCTURE.md](https://github.com/Lapinskas/test-laravel/blob/main/source/CODE-STRUCTURE.md)

The code pass quality checks thanks to integrated GitHub Actions CI/CD on every commit.
The pipeline combination of `Pint`, `PHPStan`, `PHP Insights` and `Pest` ensures high code quality and maintainability.
- Code quality tools are explained at the [main project page](https://github.com/Lapinskas/test-laravel/blob/main/README.md)

## ✅ Tests

Testing is performed using `Pest` (a wrapper over `PHPUnit`). The project includes a total of 84 tests and 175 assertions, achieving 100% code coverage while accounting for the maximum number of edge cases and failure scenarios.

Tests run both locally in Docker and as part of GitHub CI/CD pipeline, utilizing mocking (including HTTP) to eliminate the need for actual API credentials or an internet connection. Docker ensures environment consistency, which is crucial for cross-platform testing.

## 🔖 API Documentation and Versioning

The API documentation is automatically generated for Swagger (OAS 3.0) based on annotations that describe parameter types, example values, and all possible response types, including exceptions.

API versioning is ensured through the API routes' `v1` prefix, allowing clear separation of different API versions and simplifying future change management. Additionally, the API documentation, generated with Swagger, incorporates the `v1` version based on annotations in the controllers.  

The API documentation includes descriptions of breaking change strategies and endpoint tags indicating the status of each endpoint (`stable`, `deprecated`, `experimental`). Furthermore, API responses include the `x-warning` header, providing additional information about the endpoint.

## 🔍 Logging and Monitoring

- Implements basic logging with two levels: info and error.
- Uses an interface for logging and Dependency Injection (DI) to allow future integration of centralized logging solutions.
- Monitoring was not implemented due to time constraints on the task.

## 🔒 Security

- The application uses configuration from the `.env` file.
- To access keys, the application directly utilizes the `env()` function instead of `config()`, in order to avoid the risk of caching sensitive information.
- The application does not use keys for tests.
- The wrapper API does not include authentication or rate limiting.
- These security measures were not implemented due to time constraints.

## ♻️ Caching

- The project implements a well-structured caching system using Redis to reduce load on the external NYT API and improve request processing speed.
- Caching is implemented via the Cache interface, its RedisCacheRepository implementation, and integration into BestSellersService through Dependency Injection (DI).
- There is no mechanism for manual cache invalidation due to time constraints.
- For the same reason, cache hit/miss logging and general monitoring are not implemented, though it could help optimize performance.

