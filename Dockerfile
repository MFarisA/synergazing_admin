# Stage 1: Build Assets (Vite/Node)
FROM node:20-alpine AS frontend_builder
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm install && npm run build

# Stage 2: Production App (PHP)
FROM serversideup/php:8.3-fpm-nginx
WORKDIR /var/www/html
COPY . .
COPY --from=frontend_builder /app/public/build ./public/build
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN chown -R webuser:webgroup /var/www/html/storage /var/www/html/bootstrap/cache
USER webuser