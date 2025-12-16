# Stage 1: Build Assets (Frontend)
FROM node:20-alpine AS frontend_builder
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm install && npm run build

FROM serversideup/php:8.4-fpm-nginx

WORKDIR /var/www/html

USER root

RUN install-php-extensions intl

COPY . .

COPY --from=frontend_builder /app/public/build ./public/build

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

USER www-data