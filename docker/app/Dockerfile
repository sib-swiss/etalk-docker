FROM rockylinux:8.5

LABEL maintainer="Silvano Aldà"

ARG WWWGROUP

WORKDIR /var/www/html

RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail


# Install remi repo for PHP
RUN dnf -y install https://rpms.remirepo.net/enterprise/remi-release-8.rpm

# Check available PHP versions
RUN dnf -y --disablerepo="*" --enablerepo="remi-safe" list php[7-9][0-9].x86_64

# Get current available version in repos
RUN dnf -y module list php

# Enable PHP version 8.1
RUN dnf -y module reset php
RUN dnf -y module install php:remi-8.1
RUN dnf -y install php-gd php-opcache php-xml php-pdo php-fpm php-mbstring php-mysql php-zip php-posix
RUN dnf -y install supervisor
COPY php.ini /etc/php.d/99-sail.ini


# Apache
RUN yum -y install httpd httpd-tools
COPY laravel.conf /etc/httpd/conf.d/laravel.conf
RUN mkdir /run/php-fpm


# composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN dnf -y install git zip

#supervisord
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

#aliases
RUN echo 'alias pa="php artisan" ' >> /home/sail/.bashrc
RUN echo 'alias pat="php artisan tinker" ' >> /home/sail/.bashrc

# start container
COPY start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

EXPOSE 80

ENTRYPOINT ["start-container"]