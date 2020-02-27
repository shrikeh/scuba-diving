ARG PHP_TAG="7.4.3-cli-alpine3.10"

FROM php:${PHP_TAG} as php
RUN mv "${PHP_INI_DIR}/php.ini-production" "${PHP_INI_DIR}/php.ini"

RUN apk add rabbitmq-c rabbitmq-c-dev
RUN apk add  ${PHPIZE_DEPS} && pecl install amqp ds && docker-php-ext-enable amqp ds

ENTRYPOINT exit 0;
