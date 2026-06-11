#!/bin/sh
php /var/www/html/artisan migrate --force
php /var/www/html/artisan db:seed --force
php /var/www/html/artisan config:clear
php /var/www/html/artisan cache:clear
exec "$@"
