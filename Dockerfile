# Use an official PHP image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port for Laravel
EXPOSE 8000

# Start Laravel with queue worker
# Copy Supervisor configuration
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Start Supervisor
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
