FROM php:8.1-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        libzip-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo_mysql \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini
