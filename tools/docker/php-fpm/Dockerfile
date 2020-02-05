ARG PHP_TAG="7.4.1-fpm-alpine3.11"

FROM php:${PHP_TAG} as php-fpm-build

ARG APP_GROUP_NAME="app"
ARG PHP_SOCKET_DIR=/socket
ARG PHP_SOCKET_FILE=app.sock

# Get gomplate (https://docs.gomplate.ca/)

COPY --from=hairyhenderson/gomplate:v2.5.0-slim /gomplate /bin/gomplate
COPY tools/docker/php-fpm/php-fpm.d ./php-fpm.d

RUN /bin/gomplate --input-dir=./php-fpm.d --output-dir=/usr/local/etc/php-fpm.d

FROM php:${PHP_TAG} as php-fpm

ARG APP_GROUP_ID=2001
ARG APP_GROUP_NAME=app

RUN addgroup -g ${APP_GROUP_ID} -S "${APP_GROUP_NAME}"

RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

COPY --from=php-fpm-build /usr/local/etc/php-fpm.d /usr/local/etc/php-fpm.d
