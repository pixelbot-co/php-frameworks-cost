FROM ubuntu:18.04

ENV DEBIAN_FRONTEND=nonintercative

# pft
COPY . /root/pft/client

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

# Script for running multiple services from one container (yeah, I know)
RUN chmod +x /root/pft/client/start.sh

ENTRYPOINT ["/root/pft/client/start.sh"]