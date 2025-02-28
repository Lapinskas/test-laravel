# test-laravel

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
should list theese 4 containers, similar to following output
```
nyt-nginx-fpm - Up 16 minutes
nyt-php - Up 16 minutes
nyt-redis - Up 16 minutes
nyt-database - Up 16 minutes (healthy)
```
## Code quality and CI/CD

### Insights

PHP Insights performs analysis of code quality and coding style.
It provides beautiful overview of code architecture and it's complexity.

#### Run PHP insights manually

You can run PHP insights manually for the whole project like following:

    composer insights

You can run PHP insights manually for a specific file, providing relative path, as an example:

    artisan insights <path>

> TIP: To know the className of an Insight, launch `insights` with `-v` option (verbose)

### PSPStan & Larastan

PHP Insights performs analysis of code quality and coding style. It provides beautiful overview of code architecture and it's complexity.

Larastan is a PHPStan wrapper for Laravel. Larastan focuses on finding errors in your code. It catches whole classes of bugs even before you write tests for the
code.

#### Run PHPStan manually

You can run PHPStan manually for the whole project like following:

    ./vendor/bin/phpstan analyse

### Configure PHPStan

At the moment the project is configured to run on assertion level=10 (the highest) of PHPStan rule levels.

### Laravel Pint

Laravel pint is used as the default code formatter.

### Pest Tests

Pest Tests cover 100% of the code to ensure the code quality

#### Run Pest manually

You can run Pest tests manually for the whole project like following:

    ./vendor/bin/pest


### Validate Before Merge Request

A custom composer script is available to validate the codebase before pushing the code, and can be run via:

    composer quality

This script will run the following steps:

1. Laravel Pint
2. PSPStan
3. PHP Insights
4. Pest Tests

### GitHub CI/CD

The following steps configured for GitHub Actions:
1. Laravel Pint (with fixes, if needed)
2. PSPStan
3. PHP Insights
4. Pest tests
