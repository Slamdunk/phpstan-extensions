all: csfix static-analysis test
	@echo "Done."

vendor: composer.json
	composer update
	composer bump
	touch vendor

.PHONY: csfix
csfix: vendor
	PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix --verbose

.PHONY: static-analysis
static-analysis: vendor
	vendor/bin/phpstan analyse

.PHONY: test
test: vendor
	vendor/bin/phpunit --coverage-text
