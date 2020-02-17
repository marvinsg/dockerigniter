FROM php:7-apache

RUN apt-get update && apt-get install -y libmcrypt-dev \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo_mysql bcmath mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get -y install libpng-dev libjpeg-dev libjpeg62-turbo-dev libfreetype6-dev libvpx-dev libwebp-dev libxpm-dev

RUN apt-get install -y git