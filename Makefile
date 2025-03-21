# Variables
PHP = php
COMPOSER = composer
SYMFONY = symfony
COMPOSER_INSTALL = $(COMPOSER) require
SYMFONY_CONSOLE = $(PHP) bin/console
VENDOR = vendor/bin/

## —— 🔥 App ——
init: ## Création de la base de donnée, gestion des migrations & fixtures
		$(COMPOSER) install
		$(SYMFONY_CONSOLE) doctrine:database:create
		$(SYMFONY_CONSOLE) doctrine:schema:update --force
		$(SYMFONY_CONSOLE) d:f:l --no-interaction --group=app
		$(SYMFONY_CONSOLE) doctrine:database:create --env=test
		$(SYMFONY_CONSOLE) doctrine:schema:update --force --env=test
		$(SYMFONY_CONSOLE) d:f:l --no-interaction --group=test --env=test

start: ## Lancement du serveur de symfony
		$(SYMFONY) serve

test: ## Lancement de l'ensemble des tests
		$(VENDOR)phpunit
		$(VENDOR)phpstan analyse --memory-limit 256M

coverage: ## Création d'un rapport de coverage
		$(PHP) -d xdebug.mode=coverage ./vendor/bin/phpunit --coverage-html tests/report

## —— 📚 Database ——
create-database: ## Création de la base de donnée
		$(SYMFONY_CONSOLE) doctrine:database:create

save-database: ## Enregistrer dans la base de donnée
		$(MAKE) make-migration
		$(MAKE) migration-migrate
		$(MAKE) fixtures

## —— 🎶 Symfony ——
make-migration: ## Création de la migration 
		$(SYMFONY_CONSOLE) make:migration

migration-migrate: ## Création de la migration 
		$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction

fixtures: ## Création des fixtures
		$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction

## —— 🛠️ Others ——
help: ## List of commands
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'