FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www

CMD ["php-fpm"]
