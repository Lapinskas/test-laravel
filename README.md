# Lendflow Assessment for Laravel
This repo is the assessment task for Laravel done by Vladas Lapinskas on March 2025

The repo consist of the [Docker project](https://github.com/Lapinskas/test-laravel/blob/main/docker-compose.yml) and the [Laravel source code](https://github.com/Lapinskas/test-laravel/blob/main/source/README.md) 

Please check [Laravel project](https://github.com/Lapinskas/test-laravel/blob/main/source/README.md) for coding details

## Docker
Docker has classical Laravel setup
- NGINX as Web server
- PHP with required extensions
- Redis for caching
- MySQL (not used in the project at the moment, for future extensions)

## Get started
1. Clone repository
```sh
git clone git@github.com:Lapinskas/test-laravel.git
```
2. Build docker containers
```sh
docker compose build
```
3. Start docker stack
```sh
docker compose up -d
```
4. Check that you have 4 containers running
```sh
docker ps --format "{{.Names}} - {{.Status}}"
```
You should see 4 containers, similar to following output
```
nyt-nginx-fpm - Up 16 minutes
nyt-php - Up 16 minutes
nyt-redis - Up 16 minutes
nyt-database - Up 16 minutes (healthy)
```

## Homepage
The homepage of the project [http://localhost](http://localhost) provides a link to the Swagger documentation.
You can use Swagger to make API calls or use any alternative tool (Postman, curl, etc)

## Code quality and CI/CD
Project has GitHub's [CI/CD pipeline](https://github.com/Lapinskas/test-laravel/blob/main/.github/workflows/code-quality.yml) that runs code quality checks and tests on each commit

Code quality checks include:
- Pint for formatting
- PHPstan for statical analysis
- PHP Insights code analysis
- Tests

Such strong combination of checks ensures best code quality.

### Insights

PHP Insights performs analysis of code quality and coding style.
It provides beautiful overview of code architecture and it's complexity.

To run PHP Insights

    composer insights

### PSPStan

PHPStan focuses on finding errors in the code. It catches whole classes of bugs even before you write tests for the code.

To run PHPstan

    composer stan

### Laravel Pint

Laravel pint is used as the default code formatter.

To run Pint

    composer format

### Pest Tests

Pest Tests cover 100% of the code to ensure the code quality

    composer test


### Validate Before Merge Request

A custom composer script is available to validate the codebase before pushing the code, and can be run via:

    composer quality

This script will run the following steps:

1. Laravel Pint
2. PSPStan
3. PHP Insights
4. Pest Tests
