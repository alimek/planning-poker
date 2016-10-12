FROM php:7.0-fpm

RUN apt-get update && buildDeps="libpq-dev libzip-dev openssl" && apt-get install -y $buildDeps git  nano wget --no-install-recommends
RUN docker-php-ext-install pdo zip bcmath
RUN pecl install mongodb
RUN echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/20-mongodb.ini

RUN wget https://getcomposer.org/composer.phar && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer
RUN docker-php-ext-install sockets

WORKDIR /app