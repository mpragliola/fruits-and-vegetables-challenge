.PHONY: build run sh stop rm clean load-env

load-env:
	$(eval include .env)
	$(eval export)

build: load-env
	docker build -t $$SERVICE_NAME -f docker/Dockerfile . --no-cache

run:
	docker run -d --name fruits-and-vegetables -p 8080:80 mpragliola/fruits-and-vegetables

sh:
	docker exec -it fruits-and-vegetables sh

stop:
	docker stop fruits-and-vegetables

rm:
	docker rm fruits-and-vegetables

clean: stop rm
