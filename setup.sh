#!/bin/sh

# Setup and run docker containers using Laradock
rm -rf laradock
git clone https://github.com/Laradock/laradock.git
cp .laradock.env.archistar laradock/.env
cd laradock
docker-compose up -d nginx mysql phpmyadmin workspace php-fpm

# Create database
docker-compose exec mysql bash -c "mysql -u root -proot -e 'CREATE DATABASE IF NOT EXISTS archistar;'"

# Initialize Laravel
docker-compose exec workspace bash -c "composer install && cp .env.archistar .env && php artisan key:generate && php artisan migrate:refresh --seed && composer dump-autoload && php artisan view:clear && php artisan cache:clear && php artisan clear-compiled"

cd ..


