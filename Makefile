SHELL := /usr/bin/env bash

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

down:
	docker-compose down

up:
	docker-compose up

prune: down
	docker volume prune -f

build:
	docker-compose build --parallel

build-clean:
	docker-compose build --no-cache --parallel
