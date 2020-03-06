.ONESHELL:
SHELL := /usr/bin/env sh
ROOT_DIR:="$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))"
.DEFAULT: help
.PHONY: help
ifndef VERBOSE
.SILENT:
endif

-include .env

run: build up

rebuild: prune build-clean docker-up

clean: docker-down
	docker system prune -a -f
	docker volume rm -f $(docker volume ls -qf dangling=true)

docker-down:
	docker-compose -f docker-compose.yml -f "${ROOT_DIR}/tools/docker/compose/docker-compose-dev.yml" down -v

docker-php-base:
	echo 'Building php base image for tagging...'
	docker-compose -f "${ROOT_DIR}/tools/docker/compose/docker-compose-base.yml" build --quiet php-base

docker-up: docker-down
	docker-compose -f docker-compose.yml -f "${ROOT_DIR}/tools/docker/compose/docker-compose-dev.yml" up --remove-orphans

prune: docker-down
	docker volume prune -f

docker-build:
	docker-compose build --parallel

webpack:
	docker-compose run frontend-build

build-clean: docker-php-base
	docker-compose build --no-cache --parallel

pre-commit: check-changed-php

check-changed-php:
	${ROOT_DIR}/tools/bin/check-changed-php.sh;

hook-add-pre-commit:
	cd "${ROOT_DIR}/.git/hooks"; test -e pre-commit || ln -s ../../hooks/pre-commit.sh ./pre-commit

include tools/Makefile.dev
