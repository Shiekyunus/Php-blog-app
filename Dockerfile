# Stage 1: Build & Compose Dependencies (Use latest stable Composer image)
FROM composer:latest as builder
WORKDIR /app
COPY . .

# Run installation ignoring platform constraints temporarily or update dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=php

# Stage 2: Production Execution Environment (Upgrade to PHP 8.4)
FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    nginx \
    shadow \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    unzip \
    gcompat \
    icu-dev

# Install required PHP extensions for Laravel & MySQL
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip intl bcmath

WORKDIR /var/www/html

# Copy application source and vendors from builder stage
COPY --from=builder /app /var/www/html

# Set appropriate ownership and permissions for Laravel backend
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Custom Nginx Configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
