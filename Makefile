csfix:
	docker-compose exec --user=$(shell id -u) php composer csfix

phpstan:
	docker-compose exec --user=$(shell id -u) php composer phpstan

test:
	docker-compose exec -T --user=$(shell id -u) php ./bin/phpunit --color=always
