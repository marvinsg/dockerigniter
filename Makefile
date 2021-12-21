current-dir:=$(dir $(abspath $(lastword $(MAKEFILE_LIST))))
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

define HEADER

██████╗░░█████╗░░█████╗░██╗░░██╗███████╗██████╗░██╗░██████╗░███╗░░██╗██╗████████╗███████╗██████╗░
██╔══██╗██╔══██╗██╔══██╗██║░██╔╝██╔════╝██╔══██╗██║██╔════╝░████╗░██║██║╚══██╔══╝██╔════╝██╔══██╗
██║░░██║██║░░██║██║░░╚═╝█████═╝░█████╗░░██████╔╝██║██║░░██╗░██╔██╗██║██║░░░██║░░░█████╗░░██████╔╝
██║░░██║██║░░██║██║░░██╗██╔═██╗░██╔══╝░░██╔══██╗██║██║░░╚██╗██║╚████║██║░░░██║░░░██╔══╝░░██╔══██╗
██████╔╝╚█████╔╝╚█████╔╝██║░╚██╗███████╗██║░░██║██║╚██████╔╝██║░╚███║██║░░░██║░░░███████╗██║░░██║
╚═════╝░░╚════╝░░╚════╝░╚═╝░░╚═╝╚══════╝╚═╝░░╚═╝╚═╝░╚═════╝░╚═╝░░╚══╝╚═╝░░░╚═╝░░░╚══════╝╚═╝░░╚═╝

endef
export HEADER

## Default entry point. Show help menu
.PHONY: help
help: ## Show help menu
	clear
	@echo "$$HEADER"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2);printf " $(COLOR_YELLOW)%-20s$(COLOR_PURPLE)->$(COLOR_CYAN)  %s\n", $$1, $$2}' $(MAKEFILE_LIST)
	@echo ""

## Boot dev environment
.PHONY: dev
dev: hosts-entry docker-build dev-env ## Boots development environment
	docker-compose up -d --no-build --remove-orphans --force-recreate
	@docker exec -ti php-dockerigniter composer install
	@echo "####################################################################"
	@echo ""
	@echo "---------- Dockerigniter is up, yo can start coding now :) ---------"
	@echo "          open http://dev.dockerigniter.local:8989 in your browser"
	@echo ""
	@echo "####################################################################"

## Switch to dev env
.PHONY: dev-env
dev-env: ## Switch the config file to DEV Env
	cp -r resources/codeigniter-config-templates/dev/index.php index.php

## Switch to stg env
.PHONY: dev-stg
stg-env: ## Switch the config file to STG Env
	cp -i resources/codeigniter-config-templates/stg/index.php index.php

## Switch to prod env
.PHONY: prod-env
prod-env: ## Switch the config file to PROD Env
	cp -i resources/codeigniter-config-templates/prod/index.php index.php

## Build docker images
.PHONY: docker-build
docker-build: ## Recreate new php images
	docker-compose build

## Set up an entry for this project's host names in /etc/hosts
.PHONY: hosts-entry
hosts-entry: ## Add an entry for dockerigniter.local in etc/hosts
	(grep "$(HOSTS_ENTRY)" /etc/hosts) || echo '$(HOSTS_ENTRY)' | sudo tee -a /etc/hosts

## Delete hosts entry and restore the previous backup
.PHONY: del-hosts-entry
del-hosts-entry: ## Delete hosts entry for dockerigniter.local in etc/hosts
	sudo sed -i".bak" "/$(HOSTS_ENTRY)/d" /etc/hosts

## Enter to PHP-FPM Docker Container in Bash Mode
.PHONY: php
php: ## Enter to PHP-FPM Docker Container in Bash Mode
	@docker exec -ti php-dockerigniter bash

## Execute Composer require
.PHONY: composer-require
composer-require: ## Add composer packages
	@docker exec -ti php-dockerigniter composer require ${package} ${parameters}

## Install composer dependencies
.PHONY: composer-vendor
composer-vendor: ## Execute composer install
	@docker exec -ti php-dockerigniter composer install

## Run unit tests
.PHONY: test-unit
test-unit: ## Run PHPUnit tests
	@docker exec -ti php-dockerigniter php -n -dzend_extension=xdebug -dxdebug.mode=coverage ./vendor/bin/phpunit --coverage-text -c application/tests/
