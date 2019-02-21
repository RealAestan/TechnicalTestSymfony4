#!/usr/bin/env bash

set -e

# Start our containers
docker-compose build
docker-compose up -d
echo $(docker network inspect bridge | grep Gateway | grep -o -E '([0-9]{1,3}\.){3}[0-9]{1,3}') "symfony.local" >> /etc/hosts

# Install dependencies
docker-compose exec --user=$(shell id -u) php composer install
docker-compose exec --user=$(shell id -u) yarn install
docker-compose exec --user=$(shell id -u) yarn run dev

# Prepare database
docker-compose exec --user=$(shell id -u) php bin/console doctrine:database:create
docker-compose exec --user=$(shell id -u) php bin/console doctrine:migrations:migrate --no-interaction

# Warmup cache to avoid first slow loading :)
docker-compose exec --user=$(shell id -u) php bin/console cache-warmup

# Open if possible the project
xdg-open http://symfony.localhost:8080 &
