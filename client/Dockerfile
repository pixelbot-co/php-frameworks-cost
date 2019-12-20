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

RUN pwd
# Installing wrk
RUN git clone https://github.com/wg/wrk.git wrk
RUN pwd
RUN cd wrk && make
# RUN cp wrk /usr/local/bin
RUN cd ..
# pft
RUN git clone https://github.com/pixelbot-co/php-frameworks-cost.git pft

# Script for running multiple services from one container (yeah, I know)
RUN chmod +x pft/client/start.sh

ENTRYPOINT ["pft/client/start.sh"]