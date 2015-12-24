cs:
	php-cs-fixer fix --verbose

cs_dry_run:
	php-cs-fixer fix --verbose --dry-run

test:
	mkdir -p build/logs
	phpunit -c phpunit.xml.dist
