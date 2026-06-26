#!/bin/sh
set -e

php /var/www/html/artisan migrate --force
php /var/www/html/artisan db:seed --class=RoleAndPermissionSeeder --force
php /var/www/html/artisan config:clear

# Start php-fpm in background
php-fpm -D

# Start nginx in foreground (keeps container alive)
exec nginx -g 'daemon off;'
