SHELL := /usr/bin/env bash
ROOT_DIR:=$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

.DEFAULT: help
.PHONY: help
ifndef VERBOSE
.SILENT:
endif

run: init build up

init:
	test -e ./.env || cp -p ./.env.dist ./.env

rebuild: prune build-clean up

clean: down
	docker system prune -a -f
	docker volume rm -f $(docker volume ls -qf dangling=true)

docker-down:
	docker-compose down

docker-up:
	docker-compose up

prune: down
	docker volume prune -f

docker-build:
	docker-compose build --parallel

webpack:
	docker-compose run frontend-build

build-clean:
	docker-compose build --no-cache --parallel

test: test-php

test-php: composer-validate phplint phpcs phpstan phpspec phpunit behat phpmetrics infection

lint-changed: lint-changed-php

lint-changed-php:
	 ./tools/bin/lint-changed-php.sh

validate: composer-validate lint

composer-validate:
	composer validate

lint: phplint

phpunit:
	php ./vendor/bin/phpunit --prepend "./tests/unit/xdebug-filter.php"

infection:
	php ./vendor/bin/infection --debug -j2 --coverage=build/coverage --filter=application/app

behat:
	php ./vendor/bin/behat

phplint:
	php ./vendor/bin/phplint

phpstan:
	php ./vendor/bin/phpstan analyse

phpcs:
	php ./vendor/bin/phpcs --runtime-set ignore_warnings_on_exit true --cache -p application tests

phpcbf:
	php ./vendor/bin/phpcbf -p -vvv

phpspec:
	php ./vendor/bin/phpspec run

phpmetrics:
	php ./vendor/bin/phpmetrics --report-html=build/metrics application

browse-metrics:
	open file:///${ROOT_DIR}/build/metrics/index.html
