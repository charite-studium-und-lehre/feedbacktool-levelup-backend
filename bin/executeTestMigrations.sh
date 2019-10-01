#!/bin/bash

cd `dirname $0`/..

APPLICATION_ENV=regtest APP_ENV=test DATABASE_URL=mysql://levelup_intern_regtest:okah*ghai7Ei@127.0.0.1:3306/levelup_intern_regtest bin/console doctrine:migrations:migrate --no-interaction $1 $2
