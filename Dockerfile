# --- Stage 1: Build Frontend Assets (Vite) ---
FROM node:20-alpine AS frontend_builder

WORKDIR /app

# Copy file dependency frontend
COPY package*.json vite.config.js ./
# Copy resources (css/js/views)
COPY resources ./resources

# Install & Build
RUN npm install
RUN npm run build

# --- Stage 2: Production Server (PHP + Nginx) ---
# Menggunakan image serversideup yang optimized untuk Laravel
FROM serversideup/php:8.3-fpm-nginx

WORKDIR /var/www/html

# Copy semua source code project ke container
COPY . .

# Copy hasil build frontend dari Stage 1 ke folder public
COPY --from=frontend_builder /app/public/build ./public/build

# Install dependency Backend (Composer)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Fix permission agar Nginx/PHP bisa baca tulis
RUN chown -R webuser:webgroup /var/www/html/storage /var/www/html/bootstrap/cache

# Switch user ke webuser (Security Best Practice)
USER webuser