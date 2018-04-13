#!/usr/bin/env bash

# Initiales Erstellen der benötigten Verzeichnisse und Setzen der Rechte

cd `dirname $0`/..
pwd

mkdir -p var/uploads/data/Modulhandbuch/Anhang
mkdir -p var/uploads/data/Modulhandbuch/Cover
mkdir -p var/uploads/data/Modulhandbuch/OE-Plan
mkdir -p var/uploads/data/Modulhandbuch/Rueckseite
mkdir -p public/modell/modulhandbuecher
mkdir -p bin

scripts/shell/createSecretToken.sh

sudo chgrp -R www-data var public/modell/modulhandbuecher
sudo chmod -R g+ws var public/modell/modulhandbuecher

# Symfony: Gruppenrecht mit ACL setzen, damit man auf CLI den Cache löschen kann.
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
sudo setfacl -dR -m g:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
sudo setfacl -R  -m g:"$HTTPDUSER":rwX -m u:$(whoami):rwX var

sudo touch ./bin/symfony_requirements
sudo chmod a+rwx ./bin/symfony_requirements

echo Fertig.
echo
if [ ! -f public/zend/.htaccess ]; then
    cp docs/htaccess public/zend/.htaccess
    echo Um die Einrichtung abzuschließen, bearbeiten Sie public/zend/.htaccess: vi public/zend/.htaccess
    echo und setzen Sie dort eine Umgebung.
    echo Anschließend Starten Sie ./install.sh
    echo
fi
