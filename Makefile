SHELL := /bin/bash

.DEFAULT_GOAL := choose-run

MAKE_PHP_8_1_BIN ?= php8.1
MAKE_PHP ?= ${MAKE_PHP_8_1_BIN}

.PHONY: phpcs
phpcs:
	${MAKE_PHP} vendor/bin/phpcs --standard=phpcs.xml app tests database

.PHONY: phpcbf
phpcbf:
	-${MAKE_PHP} vendor/bin/phpcbf --standard=phpcs.xml app tests database

.PHONY: up
up:
	docker-compose build
	docker-compose up -d
	docker-compose exec laravel.test php artisan migrate
	docker-compose exec laravel.test php artisan db:seed
	docker-compose exec -T laravel.test nohup php artisan queue:work > /dev/null 2>&1 &

.PHONY: down
down:
	docker-compose down

.PHONY: test
test: up
	docker-compose exec laravel.test php artisan test
	make down
