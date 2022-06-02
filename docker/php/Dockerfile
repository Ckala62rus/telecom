FROM php:8.0.9-fpm-alpine3.14

RUN apk update
RUN apk upgrade

RUN apk add --no-cache \
    curl \
    bash \
    nano \
    $PHPIZE_DEPS \
    icu \
    icu-dev \
    libxml2-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN pecl update-channels \
    && pecl install xdebug \
    && pecl install xhprof

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    opcache \
    soap

RUN docker-php-ext-enable \
    xdebug \
    xhprof