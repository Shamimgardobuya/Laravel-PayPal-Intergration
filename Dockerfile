# Use an official PHP image as a base
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
    && apt-get install apache2 \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory for PHP
WORKDIR /var/www/html/payment_app

# Copy the frontend files and package.json/package-lock.json





#Create a new user and group
#Create a new system user and group
RUN groupadd --system laravel && useradd --system --gid laravel laravel
# Set ownership of app files
RUN chown -R laravel:laravel /var/www/html

# Switch to that user
USER laravel

# Copy Apache site config
COPY payment_app.conf /etc/apache2/sites-available/payment_app.conf

# Enable the site and required modules
RUN a2enmod rewrite \
    && a2ensite payment_app.conf \
    && a2dissite 000-default.conf \
    && apachectl configtest
# ...existing code...


COPY --chown=laravel:laravel package.json package-lock.json /var/www/html/payment_app

# Install frontend dependencies (node_modules)
RUN npm install

# Copy the remaining project files
COPY --chown=laravel:laravel . /var/www/html/payment_app

# Build the frontend assets
RUN npm run build

# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader
RUN composer install --no-dev --optimize-autoloader --prefer-dist
# Set permissions for PHP and storage directories
RUN chmod -R 775 storage bootstrap/cache

# Expose port 8000 for Laravel
EXPOSE 8000

# Install Supervisor (if needed for running queue workers)
COPY queue-worker.conf /etc/supervisor/conf.d/queue-worker.conf

# Start Supervisor to manage Laravel and queue workers
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/queue-worker.conf"]
