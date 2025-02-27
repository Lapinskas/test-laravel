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
