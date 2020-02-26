FROM shrikeh/scuba-diving-base:latest as build-composer

WORKDIR /composer
COPY ./tools/bin/install-composer.sh .

RUN sh ./install-composer.sh

FROM shrikeh/scuba-diving-base:latest as run-composer

RUN apk add --no-cache git
COPY --from=build-composer /composer /bin

ENV COMPOSER_BUILD='--no-dev'

WORKDIR /build

COPY ./composer.json .
COPY ./composer.lock .

ENTRYPOINT php /bin/composer.phar install ${COMPOSER_BUILD} --classmap-authoritative --no-scripts
