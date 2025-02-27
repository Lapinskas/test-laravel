FROM php:8.4-fpm AS php-base

ARG UID
ARG GID

# Environment variables
ENV USERNAME=www-data
ENV APP_HOME=/var/www/html
ENV XDEBUG_VERSION=3.4.1
ENV COMPOSER_ALLOW_SUPERUSER=1

# Set up users early
# Set up .config for laravel tinker
# Set up .cache for composer cache
RUN groupmod -o -g ${GID} ${USERNAME} \
    && usermod -o -u ${UID} -g ${USERNAME} ${USERNAME} \
    && mkdir -p ${APP_HOME} \
    && chown ${USERNAME}:${USERNAME} ${APP_HOME} \
    && mkdir -p /var/www/.config \
    && chown ${USERNAME}:${USERNAME} /var/www/.config \
    && mkdir -p /var/www/.cache \
    && chown ${USERNAME}:${USERNAME} /var/www/.cache

# system first update and required deps
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
    procps \
    nano \
    git \
    unzip \
    libicu-dev \
    zlib1g-dev \
    libxml2 \
    libxml2-dev \
    libreadline-dev \
    libpq-dev \
    cron \
    sudo \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP Extensions
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install \
        pdo_mysql \
        pdo \
        sockets \
        intl \
        opcache \
        zip \
        pcntl

# Redis extension
RUN pecl install redis && docker-php-ext-enable redis

RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer \
    && chown ${USERNAME}:${USERNAME} /usr/bin/composer

WORKDIR $APP_HOME

# Switch to www-data user
USER ${USERNAME}

## --- PHP-FPM XDEUG ---
FROM php-base AS php-fpm

USER root

RUN pecl install xdebug-${XDEBUG_VERSION}

# put php config for Laravel
COPY ./docker/confs/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/confs/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

USER ${USERNAME}