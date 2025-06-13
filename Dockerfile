# Use an official PHP image as a base
FROM php:8.2-fpm



COPY composer.lock composer.json /var/www/

COPY database /var/www/database

WORKDIR /var/www
#install system dependancies 

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    supervisor \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the frontend files and package.json/package-lock.json
COPY   package.json package-lock.json /var/www/

COPY . /var/www

RUN composer install 

RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache

RUN mv .env.prod .env


RUN php artisan optimize

FROM nginx:1.10-alpine AS buildNginx

ADD vhost.conf /etc/nginx/conf.d/default.conf

COPY  public /var/www/public


# Expose port 8000 for Laravel
EXPOSE 8000

# Install Supervisor (if needed for running queue workers)
COPY queue-worker.conf /etc/supervisor/conf.d/queue-worker.conf

# Start Supervisor to manage Laravel and queue workers
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/queue-worker.conf"]


