.PHONY: up down build

SAIL_PATH = ./vendor/bin/sail

all: build up composer migrate

up: build ## Поднять контейнеры
	${SAIL_PATH} up -d

down: ## Выключить контейнеры
	${SAIL_PATH} down

build: ## Собрать контейнеры
	${SAIL_PATH} build

check: composer pint stan

composer:
	${SAIL_PATH} composer install

warmup:
	${SAIL_PATH} artisan cache:clear

migrate:
	${SAIL_PATH} artisan migrate

pint:
	${SAIL_PATH} pint

stan:
	${SAIL_PATH} php ./vendor/bin/phpstan analyse

phpunit:
	${SAIL_PATH} phpunit
