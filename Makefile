default: init

.PHONY: init run-integration-tests remove-media-cache-tests tests clean shell

init: setup install-database

setup:
	docker compose up -d --build --force-recreate
	docker compose exec php-fpm bash -c "composer install"

install-database:
	docker compose exec mysql bash -c "mariadb -hmysql -uroot -proot -e 'DROP DATABASE IF EXISTS 7days_test_task2'"
	docker compose exec mysql bash -c "mariadb -hmysql -uroot -proot -e 'CREATE DATABASE 7days_test_task2'"
	docker compose exec php-fpm php bin/console d:m:m --no-interaction
	docker compose exec php-fpm php bin/console app:generate-random-post
	docker compose exec php-fpm php bin/console app:generate-random-post
	docker compose exec php-fpm php bin/console app:generate-summary-post

tests:
	SYMFONY_DEPRECATIONS_HELPER=weak docker compose exec php-fpm  vendor/bin/codecept run --steps

clean:
	docker compose exec php-fpm vendor/bin/codecept clean
	docker compose down -v

shell:
	@docker compose exec php-fpm bash
