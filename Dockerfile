FROM php:7.1-cli
RUN mkdir /var/www
WORKDIR /var/www
ADD /www/.env.example /var/www/.env
ADD . /var/
RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip unzip
RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN php composer.phar install