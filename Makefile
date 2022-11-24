include .env
export PGPASSWORD=${DB_PASSWORD}
export SAIL = "./vendor/bin/sail"
export TAG = $(shell git describe --tags)

up:
	$(SAIL) up -d
build:
	$(SAIL) build --no-cache
migrate:
	$(SAIL) artisan migrate
seed:
	$(SAIL) artisan db:seed
install:
	docker run --rm --interactive --tty -v $(shell pwd):/app composer install --ignore-platform-reqs
update:
	docker run --rm --interactive --tty -v $(shell pwd):/app composer update --ignore-platform-reqs
shell:
	docker compose exec laravel.test bash
