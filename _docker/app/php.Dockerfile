FROM php:8.1-fpm-alpine

WORKDIR /var/www

RUN docker-php-ext-install pdo_mysql && \
    rm -rf /var/lib/apt/lists/*
