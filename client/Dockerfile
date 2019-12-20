FROM ubuntu:18.04

ENV DEBIAN_FRONTEND=nonintercative

RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests \
    build-essential \
    ca-certificates \
    git \
    libssl-dev \
    && apt-get clean

# Installing wrk
RUN git clone https://github.com/wg/wrk.git /root/wrk
RUN cd /root/wrk && make

RUN apt-get install -y --no-install-recommends --no-install-suggests \
    php7.2-fpm \
    php7.2-curl \
    && apt-get clean

# pft
COPY . /root/pft/client

# Script for running multiple services from one container (yeah, I know)
RUN chmod +x /root/pft/client/start.sh

ENTRYPOINT ["/root/pft/client/start.sh"]