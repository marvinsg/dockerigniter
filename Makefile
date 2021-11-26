SHELL=/bin/bash

HOSTS_ENTRY:=127.0.0.1 dev.dockerigniter.local

COLOR_NC:=\033[0m
COLOR_WHITE:=\033[1;37m
COLOR_BLACK:=\033[0;30m
COLOR_BLUE:=\033[0;34m
COLOR_LIGHT_BLUE:=\033[1;34m
COLOR_GREEN:=\033[0;32m
COLOR_LIGHT_GREEN:=\033[1;32m
COLOR_CYAN:=\033[0;36m
COLOR_LIGHT_CYAN:=\033[1;36m
COLOR_RED:=\033[0;31m
COLOR_LIGHT_RED:=\033[1;31m
COLOR_PURPLE:=\033[0;35m
COLOR_LIGHT_PURPLE:=\033[1;35m
COLOR_BROWN:=\033[0;33m
COLOR_YELLOW:=\033[1;33m
COLOR_GRAY:=\033[0;30m
COLOR_LIGHT_GRAY:=\033[0;37m

.PHONY: help
help:
	@echo "-------------------------------------------------------------------------------------"
	@echo -e "$(COLOR_GREEN)******************************** Makefile Commands: *********************************$(COLOR_NC)"
	@echo "-------------------------------------------------------------------------------------"
	@echo -e "    $(COLOR_YELLOW)help          	    $(COLOR_PURPLE)-> $(COLOR_CYAN) Show help menu $(COLOR_NC)"
	@echo "-------------------------------------------------------------------------------------"
	@echo -e "    $(COLOR_YELLOW)dev  	       	    $(COLOR_PURPLE)-> $(COLOR_CYAN) Boots development environment $(COLOR_NC)"
	@echo -e "    $(COLOR_YELLOW)dev-env  	       	    $(COLOR_PURPLE)-> $(COLOR_CYAN) Switch the config file to DEV Env $(COLOR_NC)"
	@echo -e "    $(COLOR_YELLOW)stg-env  	       	    $(COLOR_PURPLE)-> $(COLOR_CYAN) Switch the config file to STG Env $(COLOR_NC)"
	@echo -e "    $(COLOR_YELLOW)prod-env  	       	    $(COLOR_PURPLE)-> $(COLOR_CYAN) Switch the config file to PROD Env $(COLOR_NC)"
	@echo -e "    $(COLOR_YELLOW)docker-build  	    $(COLOR_PURPLE)-> $(COLOR_CYAN) Recreate new php images $(COLOR_NC)"
	@echo -e "    $(COLOR_YELLOW)hosts-entry   	    $(COLOR_PURPLE)-> $(COLOR_CYAN) Add an entry for dockerigniter.local in etc/hosts $(COLOR_NC)"
	@echo "-------------------------------------------------------------------------------------"
	@echo -e "    $(COLOR_YELLOW)composer-require        $(COLOR_PURPLE)-> $(COLOR_CYAN) Add composer packages $(COLOR_NC)"
	@echo -e "    $(COLOR_YELLOW)composer-vendor         $(COLOR_PURPLE)-> $(COLOR_CYAN) composer install $(COLOR_NC)"
	@echo "-------------------------------------------------------------------------------------"
	@echo -e "    $(COLOR_YELLOW)test-unit     	    $(COLOR_PURPLE)-> $(COLOR_CYAN) Run PHPUnit tests $(COLOR_NC)"
	@echo "-------------------------------------------------------------------------------------"
	@echo ""

## docker-build: build docker images
.PHONY: docker-build
docker-build:
	docker-compose build

## hosts-entry: Set up an entry for this project's host names in /etc/hosts
.PHONY: hosts-entry
hosts-entry:
	(grep "$(HOSTS_ENTRY)" /etc/hosts) || echo '$(HOSTS_ENTRY)' | sudo tee -a /etc/hosts

.PHONY: del-hosts-entry
del-hosts-entry:
	sudo sed -i".bak" "/$(HOSTS_ENTRY)/d" /etc/hosts

## Composer require
.PHONY: composer-require
composer-require:
	@docker exec -ti php-dockerigniter composer require ${package} ${parameters}

## Install composer dependencies
.PHONY: composer-vendor
composer-vendor:
	@docker exec -ti php-dockerigniter composer install

## dev: Boot dev environment
.PHONY: dev
dev: hosts-entry docker-build dev-env
	docker-compose up -d --no-build --remove-orphans --force-recreate
	@docker exec -ti php-dockerigniter composer install
	@echo "####################################################################"
	@echo ""
	@echo "---------- Dockerigniter is up, yo can start coding now :) ---------"
	@echo "          open http://dev.dockerigniter.local:8989 in your browser"
	@echo ""
	@echo "####################################################################"

## Unit testing: Run unit tests
.PHONY: test-unit
test-unit:
	@docker exec -ti php-dockerigniter vendor/bin/phpunit -c application/tests/

## Switch to dev env
.PHONY: dev-env
dev-env:
	cp -r resources/codeigniter-config-templates/dev/index.php index.php

## Switch to stg env
.PHONY: dev-stg
stg-env:
	cp -i resources/codeigniter-config-templates/stg/index.php index.php

## Switch to prod env
.PHONY: prod-env
prod-env:
	cp -i resources/codeigniter-config-templates/prod/index.php index.php

.PHONY: test
test:
	@docker exec -ti php-dockerigniter echo "I'm executing composer from inside of container!"
	@docker exec -ti php-dockerigniter composer install
