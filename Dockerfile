FROM php:8.2-fpm

# 1) Install system libs & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
 && rm -rf /var/lib/apt/lists/*

# 2) Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3) Set working dir
WORKDIR /var/www/html

# 4) Copy composer files & create needed dirs
COPY composer.json composer.lock ./
RUN mkdir -p bootstrap/cache storage \
 && chmod -R 775 bootstrap/cache storage

# 5) Install PHP deps WITHOUT running scripts (skip package:discover here)
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# 6) Copy the rest of your application (including .env)
COPY . .

# 7) Now we have .env and app code—run any post-autoload scripts
RUN composer run-script post-autoload-dump \
 && php artisan key:generate --ansi \
 && php artisan config:cache --ansi \
 && php artisan route:cache --ansi \
 && php artisan view:cache --ansi

# 8) Set ownership & permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000", "--public", "public"]
