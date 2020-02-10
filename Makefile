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
	docker-compose down -v

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

test-php: composer-validate phplint infection codecept-integration behat phpcs phpmd phpstan phpmetrics

lint-changed: lint-changed-php

lint-changed-php:
	echo "Linting changed PHP files..."
	 ./tools/bin/lint-changed-php.sh

validate: composer-validate lint

composer-validate:
	echo 'Validating composer...'
	composer validate

lint: phplint

phpunit:
	echo 'Running phpunit...'
	php ./vendor/bin/phpunit --prepend "./tests/unit/xdebug-filter.php"

infection: phpunit phpspec infection-phpunit infection-phpspec

infection-phpunit:
	echo 'Running infection against PHPUnit...'
	phpdbg -qrr ./vendor/bin/infection --debug -j2 --filter=$(ROOT_DIR)/application/app --coverage=$(ROOT_DIR)/build/coverage/phpunit/ --test-framework=phpunit

infection-phpspec:
	echo 'Running infection against phpspec...'
	phpdbg -qrr ./vendor/bin/infection --debug -j2 --filter=$(ROOT_DIR)/application/src --coverage=$(ROOT_DIR)/build/coverage/phpspec/ --test-framework=phpspec

behat:
	echo 'Running behat test suite...'
	php ./vendor/bin/behat

phplint:
	echo 'Running phplint...'
	php ./vendor/bin/phplint

phpstan:
	echo 'Running phpstan...'
	php ./vendor/bin/phpstan analyse

phpcs:
	echo 'Running codesniffer...'
	php ./vendor/bin/phpcs --runtime-set ignore_warnings_on_exit true --cache -p application tests

phpcbf:
	php ./vendor/bin/phpcbf -p --runtime-set ignore_warnings_on_exit true

phpspec:
	echo 'Running phpspec...'
	./vendor/bin/phpspec run

phpmetrics:
	echo 'Creating phpmetrics...'
	php ./vendor/bin/phpmetrics --report-html=build/metrics application

browse-metrics:
	open file:///${ROOT_DIR}/build/metrics/index.html

phpmd:
	echo 'Running PHP Mess Detector...'
	php ./vendor/bin/phpmd application text phpmd.xml.dist --verbose

codecept-integration:
	php ./vendor/bin/codecept run integration
