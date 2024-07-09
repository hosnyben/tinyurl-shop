# use PHP 8.2
FROM php:8.3-fpm

# Set the working directory
WORKDIR /var/www/app

# Install common php extension dependencies
RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql

# Copy existing application directory contents
COPY . .

RUN chown -R www-data:www-data . \
    && chmod -R 775 ./storage

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy composer.json to workdir & install dependencies
COPY composer.json ./
RUN composer install

# Set the default command to run php-fpm
CMD ["php-fpm"]