FROM ubuntu:18.04

ENV DEBIAN_FRONTEND=nonintercative

RUN apt-get update && apt-get install -y --no-install-recommends --no-install-suggests nginx php7.2-fpm && apt-get clean

RUN rm /etc/nginx/sites-available/*
RUN rm /etc/nginx/sites-enabled/*
COPY ./nginx/nginx.conf /etc/nginx/
COPY ./nginx/_.conf /etc/nginx/sites-available/
COPY ./nginx/general.conf /etc/nginx
COPY ./nginx/php_fastcgi.conf /etc/nginx
COPY ./nginx/security.conf /etc/nginx
RUN ln -s /etc/nginx/sites-available/_.conf /etc/nginx/sites-enabled/_.conf
RUN chown -R www-data:www-data /var/lib/nginx

COPY ./php/www.conf /etc/php/7.2/fpm/pool.d

RUN mkdir -p /www/public
COPY ./www/public/index.php /www/public

COPY ./start.sh /start.sh
RUN chmod +x /start.sh

VOLUME ["/var/log/"]

EXPOSE 80

#CMD ["/start.sh"]

ENTRYPOINT ["/start.sh"] 