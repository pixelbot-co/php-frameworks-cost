FROM ubuntu:18.04

ENV DEBIAN_FRONTEND=nonintercative

RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests \
    composer \
    nano \
    nginx \
    php7.2-fpm \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Nginx config
RUN rm /etc/nginx/sites-available/* && rm /etc/nginx/sites-enabled/*
COPY ./nginx/nginx.conf /etc/nginx/
COPY ./nginx/_.conf /etc/nginx/sites-available/
COPY ./nginx/general.conf /etc/nginx
COPY ./nginx/php_fastcgi.conf /etc/nginx
COPY ./nginx/security.conf /etc/nginx
RUN ln -s /etc/nginx/sites-available/_.conf /etc/nginx/sites-enabled/_.conf
RUN chown -R www-data:www-data /var/lib/nginx

# PHP config
COPY ./php/www.conf /etc/php/7.2/fpm/pool.d
RUN echo "opcache.enable = 1" >> /etc/php/7.2/fpm/php.ini \
    && echo "opcache.memory_consumption = 256" >> /etc/php/7.2/fpm/php.ini \
    && echo "opcache.max_accelerated_files = 20000" >> /etc/php/7.2/fpm/php.ini \
    && echo "opcache.validate_timestamps = 60" >> /etc/php/7.2/fpm/php.ini \
    && echo "realpath_cache_size = 4096k" >> /etc/php/7.2/fpm/php.ini \
    && echo "realpath_cache_ttl = 600" >> /etc/php/7.2/fpm/php.ini \
    && echo "short_open_tag = On" >> /etc/php/7.2/fpm/php.ini

# Web index
RUN mkdir -p /www/public
COPY ./www/ /www/

# Script for running multiple services from one container (yeah, I know)
COPY ./start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

ENTRYPOINT ["/start.sh"] 