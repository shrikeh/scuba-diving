ARG PHP_TAG="7.4.1-cli-alpine3.11"

FROM php:${PHP_TAG} as php

RUN apk add --no-cache $PHPIZE_DEPS && pecl install amqp ds && docker-php-ext-enable amqp ds

ENTRYPOINT exit 0;

