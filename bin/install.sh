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
if [ "$1" == "slow" ]; then
    rm ./var/log/letztesComposerUpdate 2>/dev/null
fi
AKTUELLES_DATUM=`date +%d.%m.%Y`
LETZTES_COMPOSER_UPDATE=`cat ./var/log/letztesComposerUpdate 2>/dev/null`
if [ "$LETZTES_COMPOSER_UPDATE" != "$AKTUELLES_DATUM" -a "$1" != "fast" -o "composer.json" -nt "composer.lock" ]; then
    echo $AKTUELLES_DATUM > ./var/log/letztesComposerUpdate
    echo "Composer heute zum ersten mal aufgerufen (oder composer.json geändert oder Parameter 'slow' gesetzt);"
    echo "-> Composer-Update wird ausgeführt"
    ./composer.phar --ansi update
    touch composer.lock
else
    echo "Composer 'update' heute schon einmal ausgeführt. Starte composer install. Übergehen mit Parameter 'slow'"
    ./composer.phar --ansi install
    RESULT_CODE=$?
    if [ $RESULT_CODE -ne 0 ] ; then
        echo "Problem bei composer install festgestellt... Führe composer update aus."
        ./composer.phar --ansi update
    fi
fi

rm -rf ./var/cache/*
./bin/console cache:warmup

bin/console doctrine:migrations:migrate --no-interaction

echo
echo -e "  \e[44m\e[97m ---  Ende des Deployments --- \e[0m  "
echo
