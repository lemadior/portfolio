FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        apt-utils \
        libpq-dev \
        libpng-dev \
        libjpeg-dev \
        libxml2-dev \
        libonig-dev \
        libzip-dev \
        curl zip unzip mc \
        git && \
        docker-php-ext-install pdo_pgsql && \
        docker-php-ext-install bcmath && \
        docker-php-ext-install gd && \
        docker-php-ext-install zip && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN addgroup --gid 1001 admin
RUN adduser --gid=1001 \
            --uid=1000 \
            --disabled-password \
            --shell=/bin/bash \
            --home=/home/admin \
            --gecos GECOS \
            admin;
RUN usermod -aG www-data admin

WORKDIR /var/www
