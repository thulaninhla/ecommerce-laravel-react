# Use official PHP 8.2 FPM image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Install JS dependencies and build Vite assets
RUN npm install && npm run build


# Set proper permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose the port Laravel will run on
EXPOSE 10000

# Set environment variables
ENV APP_ENV=production
ENV APP_DEBUG=false

# Run Laravel migrations and start the app
CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000
