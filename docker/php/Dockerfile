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

RUN curl "http://pecl.php.net/get/xhprof-2.3.5.tgz" -fsL -o ./xhprof-2.3.5.tgz && \
    mkdir /var/xhprof && tar xf ./xhprof-2.3.5.tgz -C /var/xhprof && \
    cd /var/xhprof/xhprof-2.3.5/extension && \
    phpize && \
    ./configure && \
    make && \
    make install

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    opcache \
    soap
