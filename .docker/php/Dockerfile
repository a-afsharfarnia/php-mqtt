FROM php:7.2-fpm
RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev libgmp-dev
RUN ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h
RUN docker-php-ext-install mbstring pdo_mysql zip bcmath sockets gmp
RUN groupadd -g 1000 -o websocket
RUN useradd -m -u 1000 -g 1000 -o -s /bin/bash websocket
RUN mkdir /home/websocket/project
RUN chown -R websocket:websocket /home/websocket
RUN chown -R websocket:websocket /home/websocket/project
WORKDIR /home/websocket
