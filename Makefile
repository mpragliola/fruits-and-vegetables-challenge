.PHONY: build run sh stop rm clean load-dev-env gitref 
	test phpunit phpcs phpstan phpunit-ci phpcs-ci phpstan-ci

LAST_COMMIT := $(shell git rev-parse --short HEAD)
TAG := $(shell git describe --tags --abbrev=0)
export LAST_COMMIT TAG

load-dev-env:
	$(eval include .env)
	$(eval include .env.local)
	$(eval export)

# Docker compose
up:
	docker compose up
upd:
	docker compose up -d --build
down:
	docker compose down
build:
	docker compose build

# Build the Docker image for the service
build-svc: load-dev-env
	docker build -t $$SERVICE_NAME:$$LAST_COMMIT -f infra/docker/Dockerfile .

build-svc-nc: load-dev-env
	docker build -t $$SERVICE_NAME:$$LAST_COMMIT -f infra/docker/Dockerfile . --no-cache

# Tag service image with the last commit hash and optionally with a tag
tag: load-dev-env
	echo $$LAST_COMMIT
	echo $$TAG
ifdef TAG
	docker tag $$SERVICE_NAME:$$LAST_COMMIT $$SERVICE_NAME:$$TAG
endif

# Run the service in a Docker container
run: load-dev-env
	docker run -d --name $$SERVICE_NAME -p $$HTTP_PORT:80 $$SERVICE_NAME

# Shell - we use Alpine, so no bash (although we can add it)
sh: load-dev-env
	docker exec -it $$SERVICE_NAME sh

# Stop the Docker container
stop: load-dev-env
	docker stop $$SERVICE_NAME

# Remove the Docker container
rm: load-dev-env
	docker rm $$SERVICE_NAME

# Stop and remove the Docker container
clean: stop rm

# ---------------
# CI/CD & TESTING
# ---------------

# Targets for local development

phpunit:
	bin/phpunit
phpcs:
	bin/phpcs --standard=PSR12 --extensions=php --ignore=vendor,tests,build,docs .
phpstan:
	bin/phpstan analyse --memory-limit=1G --configuration=phpstan.neon

# Targets for CI/CD

phpunit-ci:
phpcs-ci:
phpstan-ci:

# Execute tests based on the CI environment
ifeq ($(CI),true)
test: phpunit-ci phpcs-ci phpstan-ci
else
test: phpunit phpcs phpstan
endif

