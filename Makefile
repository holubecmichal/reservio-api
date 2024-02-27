SHELL := /bin/bash

.DEFAULT_GOAL := choose-run

.PHONY: up
up:
	docker-compose build
	docker-compose up -d
	docker-compose exec laravel.test php artisan migrate
	docker-compose exec -T laravel.test nohup php artisan queue:work > /dev/null 2>&1 &

.PHONY: down
down:
	docker-compose down

.PHONY: test
test: up
	docker-compose exec laravel.test php artisan test
	make down
