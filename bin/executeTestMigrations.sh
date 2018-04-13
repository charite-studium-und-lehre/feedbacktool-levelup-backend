#!/bin/bash

cd `dirname $0`/..
cd application/modelsDoctrine
APPLICATION_ENV=regtest ./executeMigrations.sh -n $1 $2