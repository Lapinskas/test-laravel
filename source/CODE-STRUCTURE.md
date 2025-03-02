# Code Structure of the Application

## Summary
The code structure reflects a professional Laravel development approach, emphasizing modularity, separation of concerns, and testability. The absence of models is justified by the project’s focus as an API wrapper. The use of services and repositories with dependency injection ensures a scalable codebase.

## Structure Overview
Application is based on Laravel 12, housing the business logic, controllers, services, repositories, and related components. The structure follows a modular approach with clear separation of concerns, adhering to clean architecture principles and SOLID standards.

### Controllers  
Controller (`BestSellersController`) focuses on HTTP request handling and delegate business logic to services, aligning with RESTful principles and separation of concerns.
Exception handling is intentionally implemented within the controller layer for two primary reasons. First, it allows for tailored responses that differentiate between successful operations and exceptional cases, ensuring a clear and context-appropriate user experience. Second, isolating exception handling in the controller prevents potential issues where exceptions originating in the service layer might propagate to Laravel’s default exception handler. Such propagation could inadvertently expose internal application details—such as stack traces—potentially compromising security or revealing sensitive implementation specifics.

### Repositories  
Repositories (`NytBestSellersRepository`, `RedisCacheRepository`) encapsulate data access (API and cache), enhancing modularity and testability.

### Services  
Services (`BestSellersService`, `LaravelLogger`) manage business logic and utility functions, coordinating repository operations via interfaces.

### DTOs and Form Requests  
`BestSellersRequestDto` and `BestSellersRequest` ensure clean data transfer and validation across layers, improving type safety and user experience.

### Models  
The project lacks models in `app/Models`, which is intentional as it does not utilize a database (MySQL is configured but unused as we have no Authentication at the moment). Data is sourced from the NYT API and cached in Redis.

## Strengths  
- **Modularity:**  
  The structure separates layers (controllers, services, repositories), facilitating maintenance and scalability.  
- **Interfaces:**  
  Use of interfaces (`BestSellersApi`, `Cache`, `Logger`) supports component substitutability and testing.  
- **Type Safety:**  
  Highest `Level 10` of PHPstan statical analysis, strict typing (`declare(strict_types=1)`) and type hints enhance code reliability.  
- **Documentation:**  
  Swagger annotations in controllers improve API readability and usability.

## Potential Improvements  
- **Database Utilization:**  
  MySQL is intended for future use. 
- **Error Handling:**  
  Exceptions are handled in repositories but could be expanded in services for better transparency.

## Directory Structure

- **`Dto/`**  
  Contains Data Transfer Objects (DTOs) for structured data exchange between layers, implemented with strict typing and immutable properties, reflecting the project’s emphasis on reliability and modern PHP practices.
  - `BestSellersRequestDto.php`  
    A DTO encapsulating request parameters for the NYT Best Sellers API. Utilizes strict typing for clean and type-safe data transfer from requests to services.
  - `BestSellersResponseDto.php`  
    A DTO designed to encapsulate the response data from the New York Times Best Sellers History API.

- **`Exceptions/`**  
  Holds custom exceptions for error handling.  
  - `BestSellersApi.php`  
    A custom exception for NYT API errors, including error codes and response bodies. Used in `NytBestSellersRepository`.

- **`Helpers/`**  
  Includes utility functions or classes.  
  - `Config.php`  
    A static helper class for typed access to configuration values. Used to retrieve API settings (e.g., URL, timeouts).
  - `Getter.php`  
    A simple trait helper for immutable access to DTO and custom Exception class properties.

- **`Http/`**  
  Manages HTTP request handling, including controllers and Form Requests.  

  - **`Controllers/`**  
    Controllers for processing HTTP requests.  
    - `BestSellersController.php`  
      The primary controller for the NYT Best Sellers API. Leverages `BestSellersService` to fetch and return bestseller history data. Includes Swagger annotations for API documentation.

    - `SwaggerController.php`  
      A dummy controller serving as a root class for the Swagger documentation.

  - **`Requests/`**  
    Form Requests for validating incoming request data.  
    - `BestSellersRequest.php`  
      Validates request parameters (`author`, `title`, `offset`, `isbn`) and produces DTO with strong types. Integrated into `BestSellersController`.

- **`Interfaces/`**  
  Defines contracts for repositories and services, enabling flexibility and substitutability.  
  - `BestSellersApi.php`  
    Interface for the NYT API repository, specifying the `fetchData` method.  
  - `Cache.php`  
    Interface for caching operations, including `get`, `set`, `has`, and `delete` methods.
  - `Logging.php`  
    Interface for the logging service, including `info` and `error` methods.

- **`Models/`**
  Not used at this stage but will be needed for API Authentication 

- **`Providers/`**  
  Service providers for registering dependencies in the Laravel container.  
  - `AppServiceProvider.php`  
    Binds `BestSellersApi`, `Cache` and `Logging` for the respective implementations.

- **`Repositories/`**  
  Repositories for data access, isolating low-level operations from business logic.  
  - `NytBestSellersRepository.php`  
    Implements `BestSellersApi` for NYT API requests using Laravel’s HTTP client. Handles timeouts, retries, and error responses.  
  - `RedisCacheRepository.php`  
    Implements `Cache` for Redis-based caching, tied to the Redis driver.

- **`Rules/`**
  Custom validation rules for `isbn[]` and `offset` parameters

- **`Services/`**  
  Contains business logic and orchestrates repository interactions.  
  - `BestSellersService.php`  
    Core service for retrieving bestseller data. Integrates caching, API requests, and logging via dependency injection.  
  - `LaravelLogger.php`  
    Implements `Logging` interface for logging using Laravel’s `Log` facade.
