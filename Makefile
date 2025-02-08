SHELL := /bin/bash

.DEFAULT_GOAL := help

UID := $(shell id -u)
USERNAME := $(shell id -u -n)
GID := $(shell id -g)
GROUPNAME := $(shell id -g -n)

.PHONY: build
build: ## Build docker image
	docker build -t bank-account-web:1.25 ./docker/nginx
	docker build -t bank-account-php:8.4 ./docker/php \
		--build-arg UID=${UID} \
		--build-arg GID=${GID} \
		--build-arg USERNAME=${USERNAME} \
		--build-arg GROUPNAME=${GROUPNAME}

.PHONY: up
up: ## Start the container
	docker compose up -d

.PHONY: down
down: ## Delete the container
	docker compose down

.PHONY: php
php: ## Enter php container
	docker compose exec php bash

.PHONY: composer-install
composer-install: ## Install composer packages
	docker compose run --rm php composer install

.PHONY: phpstan
phpstan: ## Run PHPStan
	docker compose exec php composer phpstan

.PHONY: phpstan-clear-cache
phpstan-clear-cache: ## Clear PHPStan cache
	docker compose exec php composer phpstan-clear-cache

.PHONY: ecs
ecs: ## Run ecs
	docker compose exec php composer ecs

.PHONY: ecs-fix
ecs-fix: ## Run ecs fix
	docker compose exec php composer ecs-fix

.PHONY: test-all
test-all: ## Run all tests
	docker compose exec php composer test-all

.PHONY: test-unit
test-unit: ## Run PHPUnit
	docker compose exec php composer test-unit

.PHONY: test-feature
test-feature: ## Run PHPUnit
	docker compose exec php composer test-feature

.PHONY: migrate
migrate: ## Migrate database
	docker compose exec php php artisan migrate

.PHONY: migrate-test
migrate-test: ## Migrate database for test db
	docker compose exec php php artisan migrate --env=testing

.PHONY: tinker
tinker: ## Run tinker
	docker compose exec php php artisan tinker

.PHONY: help
help: ## Display a list of targets
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
