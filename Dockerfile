FROM php:8.2-fpm

# install system dependencies and PHP extensions
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
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
 && rm -rf /var/lib/apt/lists/*

# set working dir
WORKDIR /var/www/html

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# copy app
COPY . /var/www/html

# permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000","--public","public"]
