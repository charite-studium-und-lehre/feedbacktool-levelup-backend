#!/usr/bin/env bash

cd `dirname $0`/..

if  [ ! -e composer.phar ] ; then
    EXPECTED_SIGNATURE=$(curl -s https://composer.github.io/installer.sig)
    curl -s 'https://getcomposer.org/installer' > composer-setup.php
    ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');")

    if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
    then
        >&2 echo 'ERROR: Invalid installer signature'
        rm composer-setup.php
        exit 1
    fi

    php composer-setup.php --quiet
    RESULT=$?
    rm composer-setup.php
else
    ./composer.phar --ansi self-update
fi

#export SYMFONY_ENV=`php scripts/shell/getSymfonyEnvironment.php`
#echo -e "Using Symfony env \e[42m\e[97m\e[1m$SYMFONY_ENV\e[0m"

# Bug in ocramus/Installer führt zu Exception bei Deployment, wenn "chmod" aufgerufen wird.
#sed -i 's/^        chmod/#        chmod/' ./vendor/ocramius/package-versions/src/PackageVersions/Installer.php

# Composer

./composer.phar --ansi update $@
./bin/console cache:warmup

# Encore
#yarn
#
#if [ "$1" == "--no-dev" ]; then
#    yarn run encore production
#else
#    yarn run encore dev
#fi

#if [ "$SYMFONY_ENV" == "dev" ]; then
#    ./bin/console security:check --ansi
#fi

#application/modelsDoctrine/executeMigrations.sh

#if [ "$SYMFONY_ENV" == "dev" ]; then
#    echo -e "\n\e[42m\e[97m\e[1m Prüfe Code-Duplikate: \e[0m ( Details über bin/checkDuplications.sh )"
#    bin/checkDuplications.sh | grep "lines"
#fi

echo
echo -e "  \e[44m\e[97m ---  Ende des Deployments --- \e[0m  "
echo
