#!/bin/bash

cd `dirname $0`/..
vendor/bin/phpunit -c tests/phpunit-conf.xml tests/application