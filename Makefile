IS_DOCKER := $(shell docker info > /dev/null 2>&1 && echo 1)

PHP := @php
SYMFONY := @symfony
CONSOLE := $(PHP) bin/console
COMPOSER := @composer
DOCKER := @docker
COMPOSE := $(DOCKER) compose
EXEC := $(DOCKER) exec

#---------------------------------------------------------------
# If you are using docker, please discomment this line
#---------------------------------------------------------------
# ifeq ($(IS_DOCKER), 1)
# 	CONSOLE := $(EXEC) php bin/console
# 	PHP := $(COMPOSE) run  --rm --no-deps php
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
	APP_ENV=prod APP_DEBUG=0 $(COMPOSER) install --no-dev --optimize-autoloader
	@make migrate
	@make clear
	$(CONSOLE) cache:pool:clear cache.global_clearer

.PHONY: init
init: composer.lock composer.json ## Initialize project for development
	@$(call GREEN,"Install dependencies")
	$(COMPOSER) install --no-interaction
	$(CONSOLE) lexik:jwt:generate-keypair --no-interaction
	@make reset-database
	@make fixtures

.PHONY: serve
serve: vendor/autoload.php ## Run Development Server
	$(SYMFONY) serve --no-tls

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
.PHONY: docker-build
docker-build: ## Build docker image
	@$(call GREEN,"Build docker image")
	$(COMPOSE) build --no-interaction

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
## Others
##-----------------------------------
.PHONY: lint
lint: vendor/autoload.php ## Analyze code
	$(CONSOLE) lint:container
	$(PHP) vendor/bin/phpstan analyze
	$(PHP) vendor/bin/php-cs-fixer fix src --dry-run --diff

.PHONY: format
format: vendor/autoload.php ## Format code
	$(PHP) vendor/bin/php-cs-fixer fix

.PHONY: ci
ci: vendor/autoload.php ## Test project like 'github action'
	@make lint
	@make test

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
