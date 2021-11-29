FROM php:8.0-alpine as base

WORKDIR /project

RUN wget https://github.com/FriendsOfPHP/pickle/releases/download/v0.7.7/pickle.phar \
    && mv pickle.phar /usr/local/bin/pickle \
    && chmod +x /usr/local/bin/pickle

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ bash icu-dev libzip-dev \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
        zip \
        pdo_mysql

RUN pickle install apcu@5.1.21 \
    && pickle install xdebug@3.1.1

COPY etc/infrastructure/php/ /usr/local/etc/php/

RUN docker-php-ext-enable \
        apcu \
        opcache \
        xdebug

COPY composer.json ./
COPY composer.lock ./

RUN apk add --no-cache composer \
    && composer install

COPY apps ./apps/
COPY config ./config/
COPY etc ./etc/
COPY src ./src/
COPY .env ./

FROM base as console

ENTRYPOINT ["php", "apps/shop/console/bin/gelateria"]

FROM base as tests

COPY tests ./tests/
COPY phpunit.xml ./

ENTRYPOINT ["php", "vendor/bin/phpunit"]