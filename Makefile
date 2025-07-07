.PHONY: build run sh stop rm clean load-env gitref

LAST_COMMIT := $(shell git rev-parse --short HEAD)
TAG := $(shell git describe --tags --abbrev=0)
export LAST_COMMIT TAG

load-env:
	$(eval include .env)
	$(eval export)

# Build the Docker image for the service
build: load-env
	docker build -t $$SERVICE_NAME:$$LAST_COMMIT -f docker/Dockerfile . --no-cache

# Tag service image with the last commit hash and optionally with a tag
tag: load-env
	echo $$LAST_COMMIT
	echo $$TAG
ifdef TAG
	docker tag $$SERVICE_NAME:$$LAST_COMMIT $$SERVICE_NAME:$$TAG
endif

# Run the service in a Docker container
run: load-env
	docker run -d --name $$SERVICE_NAME -p 8080:80 $$SERVICE_NAME

# Shell - we use Alpine, so no bash (although we can add it)
sh: load-env
	docker exec -it $$SERVICE_NAME sh

# Stop the Docker container
stop: load-env
	docker stop $$SERVICE_NAME

# Remove the Docker container
rm: load-env
	docker rm $$SERVICE_NAME

# Stop and remove the Docker container
clean: stop rm
