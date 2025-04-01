



# Using an official PHP image
FROM php:8.2-fpm

# Install system dependencies
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

# Set working directory
WORKDIR /var/www

COPY package.json package-lock.json ./

RUN npm install

RUN npm run build
# Copy project files

#setting permissions
# RUN chown -R www-data:www-data /var/www/public/build
# RUN chmod -R 775 /var/www/public/build

COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache


# Expose port for Laravel
EXPOSE 8000
# Install Supervisor
# RUN apt-get update && apt-get install -y supervisor

# Start Laravel with queue worker
# Copy Supervisor configuration file
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Start Supervisor (which runs Laravel & queue worker)
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
