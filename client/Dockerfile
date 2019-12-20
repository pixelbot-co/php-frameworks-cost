FROM ubuntu:18.04

ENV DEBIAN_FRONTEND=nonintercative

RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests \
    build-essential \
    ca-certificates \
    git \
    libssl-dev \
    php7.2-fpm \
    php7.2-curl \
    && apt-get clean

# Installing wrk
RUN git clone https://github.com/wg/wrk.git wrk
RUN cd wrk && make
RUN cp wrk /usr/local/bin

# pft
RUN git clone https://github.com/pixelbot-co/php-frameworks-cost.git pft

# Script for running multiple services from one container (yeah, I know)
COPY ./start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

ENTRYPOINT ["/start.sh"] 