#!/bin/bash

cd `dirname $0`/..

APPLICATION_ENV=regtest APP_ENV=test DATABASE_URL=mysql://feedbacktool_regtest:okah*ghai7Ei@127.0.0.1:3306/feedbacktool_regtest bin/console doctrine:migrations:migrate --no-interaction $1 $2
