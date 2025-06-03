FROM node:18 AS node

WORKDIR /var/www

# Install frontend dependencies and build assets
COPY package*.json ./
RUN npm install
COPY resources/ resources/
COPY vite.config.js ./
RUN npm run build


FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Copy built assets from node container
COPY --from=node /var/www/public/build public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port
EXPOSE 8000

# Run Laravel commands then start the server
CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
