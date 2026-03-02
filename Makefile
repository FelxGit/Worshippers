SECRET_NAME = pem_passphrase
SECRET_FILE = ./docker/nginx/pem_passphrase.txt

deploy: create-secret
	docker-compose up --build

build:
	docker-compose build webserver

up:
	docker-compose up webserver

swarm-init:
	docker swarm init

create-secret:
	docker secret create $(SECRET_NAME) $(SECRET_FILE)
	# rm $(SECRET_FILE)

swarm-leave:
	docker swarm leave --force

clean:
	docker secret rm $(SECRET_NAME)

.PHONY: build up create-secret deploy clean swarm-init swarm-leave