#!/usr/bin/env bash

set -e

# Start our containers
docker-compose build
docker-compose up -d
cp /etc/hosts /etc/hosts.old
echo $(docker network inspect bridge | grep Gateway | grep -o -E '([0-9]{1,3}\.){3}[0-9]{1,3}') "symfony.local" >> /etc/hosts

# Install dependencies
docker-compose exec --user=$(whoami) php composer install
docker-compose exec --user=$(whoami) php yarn install
docker-compose exec --user=$(whoami) php yarn run dev

# Prepare database
docker-compose exec --user=$(whoami) php bin/console doctrine:migrations:migrate --no-interaction

# Warmup cache to avoid first slow loading :)
docker-compose exec --user=$(whoami) php bin/console cache:warmup
docker-compose exec --user=$(whoami) php chmod -R 777 var/log

# Open if possible the project
su -c "xdg-open http://symfony.localhost:8080" $SUDO_USER &
