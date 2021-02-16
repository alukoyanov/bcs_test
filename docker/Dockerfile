FROM php:7.4.15-fpm-alpine3.13

ARG YII_ENV
RUN echo "YII_ENV: $YII_ENV"

RUN apk --no-cache --update add \
    composer \
    nodejs \
    nodejs-npm \
    mariadb-dev \
    supervisor \
    zlib-dev \
    curl \
    make \
    nginx \
    openssh-client
RUN docker-php-ext-install pdo_mysql mysqli

# nginx
RUN mkdir /hosts
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/common.conf /etc/nginx/common.conf
COPY hosts /hosts

# Гитхаб в доверенные хосты
RUN mkdir ~/.ssh
RUN ssh-keyscan -t rsa github.com >> ~/.ssh/known_hosts

# Ключ гитхаба для композера
COPY php/composer-auth.json /root/.composer/auth.json

# Копируем настройки пыхи
COPY php/php.ini /usr/local/etc/php/conf.d/php.ini
RUN cp /etc/php7/php.ini /usr/local/etc/php/php.ini

# supervisor
COPY supervisor/services.ini /etc/supervisor.d/services.ini

EXPOSE 80

WORKDIR /app

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]