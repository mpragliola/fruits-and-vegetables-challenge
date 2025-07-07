.PHONY: build run sh stop rm clean load-env gitref

LAST_COMMIT := $(shell git rev-parse --short HEAD)
TAG := $(shell git describe --tags --abbrev=0)
export LAST_COMMIT TAG

load-env:
	$(eval include .env)
	$(eval export)

build: load-env
	docker build -t $$SERVICE_NAME:$$LAST_COMMIT -f docker/Dockerfile . --no-cache

tag: load-env
	echo $$LAST_COMMIT
	echo $$TAG
ifdef TAG
	docker tag $$SERVICE_NAME:$$LAST_COMMIT $$SERVICE_NAME:$$TAG
endif

run:
	docker run -d --name $$SERVICE_NAME -p 8080:80 mpragliola/$$SERVICE_NAME

sh:
	docker exec -it $$SERVICE_NAME sh

stop:
	docker stop $$SERVICE_NAME

rm:
	docker rm $$SERVICE_NAME

clean: stop rm
