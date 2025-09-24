#!/bin/sh
set -e

echo "Running artisan caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache


# Linking Laravel log to stdout so Render shows it
ln -sf /dev/stdout /var/www/html/storage/logs/laravel.log

echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx..."
nginx -g "daemon off;"
