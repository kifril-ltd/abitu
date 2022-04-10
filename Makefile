DOCKER=docker
COMPOSE=docker-compose
PHP=$(DOCKER) exec -it abitu_php
CONSOLE=$(PHP) bin/console
COMPOSER=$(PHP) composer

up:
	@${COMPOSE} --env-file .env.local up -d

down:
	@${COMPOSE} --env-file .env.local down

clear:
	@${CONSOLE} cache:clear

makedb:
	@${CONSOLE} doctrine:database:create

migration:
	@${CONSOLE} make:migration

crud:
	@${CONSOLE} make:crud

migrate:
	@${CONSOLE} doctrine:migrations:migrate

fixtload:
	@${CONSOLE} doctrine:fixtures:load

# В файл local.mk можно добавлять дополнительные make-команды,
# которые требуются лично вам, но не нужны на проекте в целом
-include local.mk
