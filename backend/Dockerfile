FROM php:8.3-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update -y \
    && apt-get install -y openssl zip unzip git curl libonig-dev libzip-dev libpq-dev librabbitmq-dev nano vim \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && docker-php-ext-install exif

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install mysqli pdo_mysql pcntl pdo_pgsql zip sockets

RUN docker-php-ext-configure pcntl --enable-pcntl

WORKDIR /

COPY .env.example .env
COPY . .


RUN composer clear-cache
RUN composer install
RUN php artisan key:generate
RUN php artisan clear-compiled

EXPOSE 8000

CMD bash -c "php artisan serve --host 0.0.0.0"
