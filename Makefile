IS_DOCKER := $(shell docker info > /dev/null 2>&1 && echo 1)

PHP := @php
SYMFONY := @symfony
CONSOLE := $(PHP) bin/console
COMPOSER := @composer
DOCKER := @docker

#ifeq ($(IS_DOCKER), 1)
#	COMPOSE := $(DOCKER) compose
#	EXEC := $(COMPOSE) exec
#	CONSOLE := $(EXEC) php bin/console
#	PHP := $(COMPOSE) run  --rm --no-deps php
#endif

GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

.DEFAULT_GOAL := help

## ----------------------------------
## App
## ----------------------------------
.PHONY: install
install: vendor/autoload.php ## Install dependencies
	@cp .env .env.local
	@$(call GREEN,"Install dependencies")
	$(COMPOSER) install --no-interaction
	$(CONSOLE) lexik:jwt:generate-keypair --no-interaction
	$(CONSOLE) doctrine:database:create --if-not-exists
	$(CONSOLE) doctrine:fixtures:load --no-interaction

.PHONY: serve
serve: vendor/autoload.php ## Run Development Server
	$(SYMFONY) serve --no-tls

.PHONY: dev
dev: vendor/autoload.php ## Alias for serve
	$(MAKE) serve

.PHONY: clear
clear: vendor/autoload.php ## Clear cache
	@$(call GREEN,"Clear cache")
	$(CONSOLE) cache:clear --env=dev
	$(CONSOLE) cache:clear --env=test

.PHONY: swagger-json
swagger-json: vendor/autoload.php ## Generate doc with swagger
	$(PHP) ./vendor/bin/openapi --format json --output ./swagger/swagger.json ./swagger/swagger.php src
	$(call GREEN,"Api Documentation generated successfully")

##
## ----------------------------------
## Database
## ----------------------------------
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
database-test: ## Create test database if not exist
	$(CONSOLE) doctrine:database:create --if-not-exists --env=test
	$(CONSOLE) doctrine:schema:update --env=test --force

##
## ----------------------------------
## Docker
## ----------------------------------

.PHONY: docker-build
docker-build: ## Build docker image
	@$(call GREEN,"Build docker image")
	docker compose build

.PHONY: docker-up
docker-up: ## Start docker containers
	@$(call GREEN,"Start docker containers")
	docker compose up -d

.PHONY: docker-down
docker-down: ## Stop docker containers
	@$(call GREEN,"Stop docker containers")
	docker compose down

.PHONY: docker-restart
docker-restart: ## Restart docker containers
	@$(call GREEN,"Restart docker containers")
	$(MAKE) docker-down
	$(MAKE) docker-up

.PHONY: docker-logs
docker-logs: ## Show docker logs
	@$(call GREEN,"Show docker logs")
	docker compose logs -f

##
## ----------------------------------
## Others
## ----------------------------------
.PHONY: lint
lint: vendor/autoload.php ## Analyze code
	$(PHP) ./vendor/bin/phpstan analyze
	$(PHP) ./vendor/bin/php-cs-fixer fix src --dry-run --diff

.PHONY: messenger-consume
messenger-consume: vendor/autoload.php ## For symfony messenger
	$(CONSOLE) messenger:consume async -vv

.PHONY: help
help: ## List commands
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
