#!/bin/sh
php /var/www/html/artisan migrate --force
php /var/www/html/artisan db:seed --class=RoleAndPermissionSeeder --force
php /var/www/html/artisan config:clear
exec "$@"
