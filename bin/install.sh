#!/usr/bin/env bash

cd `dirname $0`/..

./composer.phar --ansi update

rm -rf ./var/cache/*
./bin/console cache:warmup

bin/console doctrine:migrations:migrate --no-interaction

echo
echo -e "  \e[44m\e[97m ---  Ende des Deployments --- \e[0m  "
echo
