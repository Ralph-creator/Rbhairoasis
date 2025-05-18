FROM php:8.2-fpm

# 1) Install system libs & PHP extensions
RUN apt-get update \
 && apt-get install -y \
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

# 4) Copy only composer files, create cache/storage, install deps
COPY composer.json composer.lock ./
# ensure directories exist for post-install scripts
RUN mkdir -p bootstrap/cache storage \
 && chmod -R 775 bootstrap/cache storage \
 && composer install --no-dev --optimize-autoloader --prefer-dist

# 5) Copy the rest of the app
COPY . .

# 6) Final permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000","--public","public"]
