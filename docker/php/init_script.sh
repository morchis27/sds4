#!/usr/bin/env bash
chown -R www-data:www-data /app/storage/framework /app/storage/logs /app/storage/app /app/bootstrap/cache
chmod -R 775 /app/storage/framework /app/storage/logs /app/storage/app /app/bootstrap/cache

composer install

php artisan migrate

php-fpm
