FROM php:8.3.10-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip curl git \
    libzip-dev libpq-dev nano \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www
COPY .docker/php.ini /usr/local/etc/php/php.ini

RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www
