ARG PHP_TAG="7.4.3-fpm-alpine3.10"
# Get gomplate (https://docs.gomplate.ca/)
FROM hairyhenderson/gomplate:v2.8.0-slim as gomplate

FROM php:${PHP_TAG} as php-fpm-build

ARG APP_GROUP_NAME="app"
ARG PHP_SOCKET_DIR=/socket
ARG PHP_SOCKET_FILE=app.sock

COPY --from=gomplate /gomplate /bin/gomplate
COPY tools/docker/services/php-fpm/php-fpm.d ./php-fpm.d

RUN /bin/gomplate --input-dir=./php-fpm.d --output-dir=/usr/local/etc/php-fpm.d

FROM php:${PHP_TAG} as php-fpm

ARG APP_GROUP_ID=2001
ARG APP_GROUP_NAME=app
ARG SYMFONY_CACHE_DIR=/cache
ARG SYMFONY_LOG_DIR=/logs
ARG APP_ROOT_DIR=/diving

RUN addgroup -g ${APP_GROUP_ID} -S "${APP_GROUP_NAME}"

RUN version="$(php -r 'echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;')" \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf 'extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n' > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

COPY --from=php-fpm-build /usr/local/etc/php-fpm.d /usr/local/etc/php-fpm.d

RUN mkdir -p "${SYMFONY_CACHE_DIR}"
RUN chown www-data:www-data "${SYMFONY_CACHE_DIR}"

RUN mkdir -p "${SYMFONY_LOG_DIR}"
RUN chown www-data:www-data "${SYMFONY_LOG_DIR}"

WORKDIR "${APP_ROOT_DIR}"

COPY ./.env ./
