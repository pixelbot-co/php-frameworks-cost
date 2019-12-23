# 0.11 - Ubuntu 18.04, does not have wrk package available
#        will need to compile from source, takes too long
# 0.10.2 - Ubuntu 16.04 image, has wrk package available 
FROM phusion/baseimage:0.10.2

# Use baseimage-docker's init system.
CMD ["/sbin/my_init"]

ENV DEBIAN_FRONTEND=nonintercative

# Installing PHP 7.2 PPA for Ubuntu 16
RUN apt-get install software-properties-common \
    && add-apt-repository ppa:ondrej/php

# Installing packages
RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests \
    git \
    ntp \
    php7.2-fpm \
    php7.2-curl \
    wrk \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN git clone https://github.com/pixelbot-co/php-frameworks-cost.git /root/code

# Copying client code
#COPY . /root/code/client

