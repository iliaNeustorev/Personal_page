FROM php:8.1-fpm-alpine

WORKDIR /var/www

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

RUN docker-php-ext-install pdo_mysql && \
    rm -rf /var/lib/apt/lists/*
