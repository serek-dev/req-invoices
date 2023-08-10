#! /bin/bash
cd ./docker/

docker compose up -d
docker compose run workspace composer install
docker compose run workspace cp -n .env.example .env

docker compose run workspace php artisan migrate:refresh
docker compose run workspace php artisan db:seed --class=\\App\\Modules\\Invoices\\Infrastructure\\Database\\Seeders\\DatabaseSeeder
