# Use an official PHP image as a base
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    supervisor \
    && apt-get install redis php8.2-redis
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory for PHP
WORKDIR /var/www/html/payment_app

# Copy the frontend files and package.json/package-lock.json
COPY package.json package-lock.json /var/www/

# Install frontend dependencies (node_modules)
RUN npm install

# Copy the remaining project files
COPY . .

# Build the frontend assets
RUN npm run build

# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions for PHP and storage directories
RUN chmod -R 775 storage bootstrap/cache

# Expose port 8000 for Laravel
EXPOSE 8000

# Install Supervisor (if needed for running queue workers)
COPY queue-worker.conf /etc/supervisor/conf.d/queue-worker.conf

# Start Supervisor to manage Laravel and queue workers
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/queue-worker.conf"]
