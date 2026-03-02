ARG PHP_IMAGE_VER={$PHP_LV}

FROM ${PHP_IMAGE_VER}

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update \
    && apt-get -y install git zip unzip vim

# Install & run composer install (docker -v 4.28)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# needed to run composer install
COPY ../../composer.json ../../composer.lock .

# observation: while success, composer install seem to have no effect(no local /vendor)
# RUN composer install --no-scripts --no-autoloader

# cause bad gateway 502
# CMD ["bash", "-c", "php artisan websocket:serve"]

# Executed every up
# CMD ["bash", "-c", "composer install && php artisan serve --host 0.0.0.0 --port 8080"]

# unsuccessful in specifying the right node version within image
# RUN apk add --update --no-cache nodejs=node:14.9.0-r0 npm=node:14.9.0-r0
# COPY ./laravel-vue/package.json ./laravel-vue/package-lock.json ./
# RUN npm install
