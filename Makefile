build:
	docker build -t mpragliola/fruits-and-vegetables -f docker/Dockerfile .

run:
	docker run -d --name fruits-and-vegetables -p 8080:80 mpragliola/fruits-and-vegetables

sh:
	docker exec -it fruits-and-vegetables sh
