# Use an official Node.js image as a build stage
FROM node:18 AS build-stage

# Set working directory for Node.js build
WORKDIR /var/www

# Copy package files and install dependencies
COPY package.json package-lock.json ./
RUN npm install

# Run the build command
RUN npm run build

# Set up permissions for the build output
RUN chown -R www-data:www-data /var/www/public/build
RUN chmod -R 775 /var/www/public/build

# Use an official PHP image for the production server
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory for PHP
WORKDIR /var/www

# Copy files from build-stage (Node.js build)
COPY --from=build-stage /var/www/public/build /var/www/public/build

# Copy the rest of the project files
COPY . .

# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions for PHP and storage directories
RUN chmod -R 775 storage bootstrap/cache

# Expose port 8000 for Laravel
EXPOSE 8000

# Install Supervisor (if needed for running queue workers)
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Start Supervisor to manage Laravel and queue workers
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
