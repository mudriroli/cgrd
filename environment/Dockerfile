FROM php:8.2.9-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip

WORKDIR /var/www

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install zip
RUN docker-php-ext-install mysqli && docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable mysqli
