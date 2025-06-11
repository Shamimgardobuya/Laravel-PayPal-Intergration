# Use an official PHP image as a base

# Stage 1: Build frontend assets
FROM node:18 AS build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build


#stage2
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    supervisor \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory for PHP
WORKDIR /var/www/html/payment_app



# Copy the remaining project files
COPY . .


# Copy Vite build artifacts
COPY  --from=build  /app/public/build  /var/www/html/public/build


# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions for PHP and storage directories
RUN chmod -R 775 storage bootstrap/cache




# Copy Nginx config
COPY ./conf/nginx/nginx-site.conf /etc/nginx/sites-available/default


# Install Supervisor (if needed for running queue workers)
COPY queue-worker.conf /etc/supervisor/conf.d/queue-worker.conf

# Expose port 8000 for Laravel
EXPOSE  80
# Start Supervisor to manage Laravel and queue workers
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/queue-worker.conf"]
