FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www
