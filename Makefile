IS_DOCKER := $(shell docker info > /dev/null 2>&1 && echo 1)

#---------------------------------------------------------------
# Docker Configuration
#---------------------------------------------------------------
PHP_SERVICE_NAME := php
USER_ID := $(shell id -u)
GROUP_ID := $(shell id -g)
#---------------------------------------------------------------

#---------------------------------------------------------------
# Deployment Configuration
#---------------------------------------------------------------
SSH_KEY_FILE_PATH=~/.ssh/deployServer
USER=hasintsoa
DOMAIN_NAME=api.mydomain.local
PROJECT_DEPLOYMENT_PATH=~/www/$(DOMAIN_NAME)
#---------------------------------------------------------------

PHP := @php
SYMFONY := @symfony
CONSOLE := $(PHP) bin/console
COMPOSER := @composer
DOCKER := @docker
COMPOSE := @USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID) docker compose
EXEC := $(COMPOSE) exec $(PHP_SERVICE_NAME)

#---------------------------------------------------------------
# If you are using docker, please discomment this line
#---------------------------------------------------------------
# ifeq ($(IS_DOCKER), 1)
# 	PHP := $(EXEC) php
# 	CONSOLE := $(PHP) bin/console
# 	COMPOSER := $(EXEC) composer
# endif
#---------------------------------------------------------------

GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

.DEFAULT_GOAL := help

##-----------------------------------
## App
##-----------------------------------
.PHONY: install
install: composer.lock composer.json ## Install the project for production only
	$(COMPOSER) install --no-dev --optimize-autoloader
	$(CONSOLE) lexik:jwt:generate-keypair --overwrite --no-interaction
	$(CONSOLE) cache:clear
	$(CONSOLE) cache:pool:clear cache.global_clearer
	$(CONSOLE) messenger:stop-workers

.PHONY: init
init: composer.lock composer.json ## Initialize project for development
	@$(call GREEN,"Install dependencies")
	$(COMPOSER) install --no-interaction
	$(CONSOLE) lexik:jwt:generate-keypair --overwrite --no-interaction
	@make reset-database
	@make fixtures

.PHONY: serve
serve: vendor/autoload.php ## Run Development Server
	$(SYMFONY) serve

.PHONY: dev
dev: vendor/autoload.php ## Alias for starting docker container
	@make docker-up

.PHONY: clear
clear: vendor/autoload.php ## Clear cache
	@$(call GREEN,"Clear cache")
	$(CONSOLE) cache:clear --env=dev
	$(CONSOLE) cache:clear --env=test

.PHONY: messenger-consume
messenger-consume: vendor/autoload.php ## For symfony messenger 'async'
	$(CONSOLE) messenger:consume async -vv

.PHONY: test
test: vendor/autoload.php ## Perform test for the project
	@make clear
	$(CONSOLE) doctrine:schema:validate
	$(PHP) bin/phpunit

.PHONY: about
about: vendor/autoload.php ## Check
	$(CONSOLE) about

.PHONY: lint
lint: vendor/autoload.php ## Analyze code
	$(CONSOLE) lint:container
	$(PHP) vendor/bin/phpstan analyze --memory-limit 500M
	$(PHP) vendor/bin/php-cs-fixer fix src --dry-run --diff

.PHONY: ci
ci: vendor/autoload.php ## Integration Test
	@make lint
	@make test

##
##-----------------------------------
## Database
##-----------------------------------
.PHONY: database
database: vendor/autoload.php ## Create database for development
	@$(call GREEN,"Creating database")
	$(CONSOLE) doctrine:database:create --if-not-exists --no-interaction
	$(CONSOLE) doctrine:migrations:migrate --no-interaction

.PHONY: migration
migration: vendor/autoload.php ## Make migration
	$(CONSOLE) make:migration

.PHONY: migrate
migrate: vendor/autoload.php ## Migrate migration to database
	$(CONSOLE) doctrine:migrations:migrate

.PHONY: fixtures
fixtures: vendor/autoload.php ## Load fixtures
	$(CONSOLE) doctrine:fixtures:load --purge-with-truncate --no-interaction

.PHONY: database-test
database-test: vendor/autoload.php ## Create test database if not exist
	$(CONSOLE) doctrine:database:create --if-not-exists --env=test
	$(CONSOLE) doctrine:schema:update --env=test --force

.PHONY: reset-database
reset-database: vendor/autoload.php ## Reset database
	@$(call GREEN,"Reset database")
	$(CONSOLE) doctrine:database:drop --force --if-exists --no-interaction
	$(CONSOLE) doctrine:database:create --if-not-exists --no-interaction
	$(CONSOLE) doctrine:migrations:migrate --no-interaction

##
##-----------------------------------
## Docker
##-----------------------------------
.PHONY: docker-bash
docker-bash: ## Terminal in the container
	$(COMPOSE) run -it $(PHP_SERVICE_NAME) bash

.PHONY: docker-build
docker-build: ## Build docker image
	@$(call GREEN,"Build docker image")
	$(COMPOSE) build

.PHONY: docker-up
docker-up: ## Start docker containers
	@$(call GREEN,"Start docker containers")
	$(COMPOSE) up --build -d

.PHONY: docker-down
docker-down: ## Stop docker containers
	@$(call GREEN,"Stop docker containers")
	$(COMPOSE) down

.PHONY: docker-restart
docker-restart: ## Restart docker containers
	@$(call GREEN,"Restart docker containers")
	@make docker-down
	@make docker-up

.PHONY: docker-logs
docker-logs: ## Show docker logs
	@$(call GREEN,"Show docker logs")
	$(COMPOSE) logs -f

##
##-----------------------------------
## Deployment
##-----------------------------------
.PHONY: deploy
deploy: .rsyncignore ## Deploy Project to server
	@make ci
	@rsync -avz --delete --exclude-from='.rsyncignore' -e 'ssh -i $(SSH_KEY_FILE_PATH)' ./ $(USER)@$(DOMAIN_NAME):$(PROJECT_DEPLOYMENT_PATH)/
	@ssh -i $(SSH_KEY_FILE_PATH) $(USER)@$(DOMAIN_NAME) "cd $(PROJECT_DEPLOYMENT_PATH) && make env-update"
	@ssh -i $(SSH_KEY_FILE_PATH) $(USER)@$(DOMAIN_NAME) "cd $(PROJECT_DEPLOYMENT_PATH) && make install && make deploy-database"

.PHONY: env-update
env-update:
	@test -f .env.prod && (test -f .env && rm .env && echo "old env removed") || true; cp .env.prod .env && echo ".env updated from .env.prod" || (echo "Error: .env.prod not found" && exit 1)

.PHONY: deploy-database
deploy-database: ## Deploy mysql database to server
	$(CONSOLE) doctrine:schema:update --force
	$(CONSOLE) doctrine:schema:validate

##
##-----------------------------------
## Others
##-----------------------------------
.PHONY: format
format: vendor/autoload.php ## Format code
	$(PHP) vendor/bin/php-cs-fixer fix

.PHONY: help
help: ## List commands
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

##

#-----------------------------------
# Dependencies
#-----------------------------------
vendor/autoload.php:
	$(COMPOSER) install --no-interaction

composer.lock:
	$(COMPOSER) install --no-interaction

.rsyncignore:
	@touch .rsyncignore
