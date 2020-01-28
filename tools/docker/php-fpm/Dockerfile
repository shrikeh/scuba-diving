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

COPY --from=php-fpm-build /usr/local/etc/php-fpm.d /usr/local/etc/php-fpm.d
