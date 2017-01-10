FROM php:7.0-fpm

RUN apt-get update && buildDeps="libpq-dev libzip-dev openssl" && apt-get install -y $buildDeps git  nano wget --no-install-recommends
RUN docker-php-ext-install pdo zip bcmath
RUN pecl install mongodb
RUN echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/20-mongodb.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/London /etc/localtime
RUN "date"

RUN docker-php-ext-install sockets

WORKDIR /app

CMD ["php-fpm"]