FROM php:8.1-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
    ctype \
    iconv \
    pdo_mysql \
    zip

COPY . /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-scripts --no-autoloader

RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data var

CMD ["php-fpm"]
