FROM php:8.1-fpm

ARG user

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN groupadd -g 1000 $user && useradd -u 1000 -g 1000 -m -d /var/www/html -s /bin/bash $user && usermod -a -G www-data $user
USER $user

#EXPOSE 9000
#CMD ["php-fpm"]
#
#CMD [ "composer", "install" ]
#CMD [ "php", "artisan", "migrate" ]

#COPY ./docker/app/run.sh /tmp
#ENTRYPOINT ["/tmp/run.sh"]