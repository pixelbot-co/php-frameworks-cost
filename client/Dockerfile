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
RUN git clone https://github.com/wg/wrk.git /root/wrk
RUN cd /root/wrk && make
RUN cp /root/wrk/wrk /usr/local/bin
# pft
RUN git clone https://github.com/pixelbot-co/php-frameworks-cost.git /root/pft

# Script for running multiple services from one container (yeah, I know)
RUN chmod +x /root/pft/client/start.sh

ENTRYPOINT ["/root/pft/client/start.sh"]