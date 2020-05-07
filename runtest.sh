#!/bin/sh

cd laradock
docker-compose exec workspace bash -c "php artisan test"
