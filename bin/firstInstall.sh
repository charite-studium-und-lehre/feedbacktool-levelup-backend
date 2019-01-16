#!/usr/bin/env bash

# Initiales Erstellen der benötigten Verzeichnisse und Setzen der Rechte

cd `dirname $0`/..
pwd

# Symfony: Gruppenrecht mit ACL setzen, damit man auf CLI den Cache löschen kann.
HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
sudo setfacl -dR -m g:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
sudo setfacl -R  -m g:"$HTTPDUSER":rwX -m u:$(whoami):rwX var

sudo touch ./bin/symfony_requirements
sudo chmod a+rwx ./bin/symfony_requirements

echo Fertig.