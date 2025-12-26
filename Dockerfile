FROM php:8.2-apache

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    curl

# Install ekstensi PHP (TAMBAH pdo_mysql)
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl

# Aktifkan Apache rewrite
RUN a2enmod rewrite

# Set workdir
WORKDIR /var/www/html

# Copy composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project Laravel
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Generate APP_KEY
RUN php artisan key:generate || true

# Permission Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
