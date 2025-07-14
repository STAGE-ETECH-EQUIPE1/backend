PHP := php
SYMFONY := symfony
CONSOLE := $(PHP) bin/console
COMPOSER := composer

## ----------------------------------
## App
## ----------------------------------
.PHONY: install
install: vendor/autoload.php ## Install dependencies
	$(COMPOSER) install --no-interaction
	$(CONSOLE) lexik:jwt:generate-keypair --no-interaction
	$(CONSOLE) doctrine:database:create --if-not-exists
	$(CONSOLE) doctrine:fixtures:load --no-interaction

.PHONY: serve
serve: vendor/autoload.php ## Run Development Server
	$(SYMFONY) serve

.PHONY: dev
dev: vendor/autoload.php ## Alias for serve
	$(MAKE) serve

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
	$(CONSOLE) doctrine:fixtures:load --no-interaction

##
## ----------------------------------
## Others
## ----------------------------------
.PHONY: lint
lint: vendor/autoload.php ## Analyze code
	$(PHP) ./vendor/bin/phpstan analyze
	$(PHP) ./vendor/bin/php-cs-fixer fix src --dry-run --diff

.PHONY: clear
clear: ## Clear cache
	$(CONSOLE) cache:clear

.PHONY: help
help: ## List commands
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
