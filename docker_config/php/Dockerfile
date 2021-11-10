FROM php:8.0-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && \
    apt-get install -y \
    libzip-dev

RUN docker-php-ext-enable apcu

RUN apt-get update
RUN apt-get install -y zlib1g-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng12.0 imagemagick git
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

WORKDIR /usr/src/app

COPY --chown=1000:1000 ./ /usr/src/app

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-scripts --prefer-dist --no-interaction
