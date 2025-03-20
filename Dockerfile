# Use an official PHP runtime
FROM php:8.1-fpm

# Install system dependencies and PostgreSQL extension
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for caching dependencies)
COPY composer.json composer.lock ./

# Install composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Copy Laravel project files
COPY . .

# Set correct permissions
RUN chmod -R 777 storage bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
