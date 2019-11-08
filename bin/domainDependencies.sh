#!/bin/bash

cd `dirname $0`/..

FILENAME="/tmp/dependencies.png"
bin/tools/dephpend uml --no-classes -d 1 -e "/(ConvenientImmutability|Assert|Doctrine|Symfony|Twig|Common|Jumbojett|Sensio)/" src --output=$FILENAME

xdg-open $FILENAME
