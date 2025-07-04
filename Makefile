PHP := php
SYMFONY := symfony
CONSOLE := $(PHP) bin/console

## ----------------------------------
## App
## ----------------------------------
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

##
## ----------------------------------
## Others
## ----------------------------------
.PHONY: lint
lint: vendor/autoload.php ## Analyze code
	$(PHP) ./vendor/bin/phpstan analyze

.PHONY: clear
clear: ## Clear cache
	$(CONSOLE) cache:clear

.PHONY: help
help: ## List commands
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
