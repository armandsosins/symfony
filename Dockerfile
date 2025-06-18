# 1) Base image
FROM php:8.3-fpm-alpine

# 2) System deps + build tools
RUN apk add --no-cache \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    zip \
    autoconf \
    gcc \
    g++ \
    make \
    && docker-php-ext-install \
    intl \
    pdo_mysql \
    opcache \
    zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apk del autoconf gcc g++ make

# 3) Install Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4) Set working dir
WORKDIR /srv/app

# 5) Copy only composer files, install deps, ignore platform reqs
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --prefer-dist \
    --no-progress \
    --ignore-platform-reqs \
    && rm -rf /root/.composer/cache

# 6) Copy rest of the app
COPY . .

# 7) Prepare Symfony writable dirs
RUN mkdir -p var/cache var/log \
    && chown -R www-data:www-data var

# 8) Expose & run
EXPOSE 9000
CMD ["php-fpm"]
