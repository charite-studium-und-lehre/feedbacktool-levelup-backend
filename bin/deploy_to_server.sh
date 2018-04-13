#!/bin/bash
# Anwendung:
# ./deploy.sh
# ./deploy.sh <Parameter für git pull>
# UPLOAD_PATH=<Pfad, wo git pull aufgerufen werden soll> ./deploy.sh

if [[ -z $UPLOAD_PATH ]]; then
    BRANCH=`git rev-parse --abbrev-ref HEAD`
    echo -e "LLP-Upload für Branch \e[1;34;107m $BRANCH \e[0m"

    if [[ $BRANCH == "master" ]]; then
        UPLOAD_PATHS=("/var/www/prod")
    elif [[ $BRANCH == "develop" ]]; then
        UPLOAD_PATHS=("/var/www/testumgebung")
    elif [[ $BRANCH =~ ^release/Release.* ]]; then
        UPLOAD_PATHS=("/var/www/test1")
    elif [[ $BRANCH =~ ^feature/Feature-Symfony.* ]]; then
        UPLOAD_PATHS=("/var/www/projekte")
    elif [[ $BRANCH =~ ^feature/.* ]]; then
        UPLOAD_PATHS=("/var/www/test2")
    else
        UPLOAD_PATHS=("/var/www/$BRANCH")
    fi
fi

git gc --auto
for UPLOAD_PATH in ${UPLOAD_PATHS[@]}; do
    echo -e "Update von Pfad auf Server: \e[1;31;107m $UPLOAD_PATH \e[0m"
    echo
    ssh llp "cd $UPLOAD_PATH; git pull $@; git gc --auto"
    if [ $BRANCH == "develop" ]; then
        ssh llp "cd $UPLOAD_PATH; bash bin/install.sh"
    else
        ssh llp "cd $UPLOAD_PATH; bash bin/install.sh --no-dev"
    fi

    # Release branch: switch to current release branch
    if [[ $BRANCH =~ ^release/Release.* ]]; then
        ssh llp "cd $UPLOAD_PATH; git checkout $BRANCH;"
    fi
done
