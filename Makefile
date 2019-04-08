UID := $(shell id -u)

dshell:
	docker-compose run --rm --user=$(UID) --service-ports --entrypoint=ash php

dclean:
	@docker-compose down --remove-orphans -v --rmi=local

up:
	@php bin/console doctrine:migrations:migrate --no-interaction
	@php bin/console server:run "*:8080"
