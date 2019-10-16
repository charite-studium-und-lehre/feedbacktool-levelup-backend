#!/bin/bash

# If anything goes wrong, exit and do not continue
#set -e
#set -o pipefail


DB_NAME=$1
BACKUP_PATH=$2/$1

if [ -z $2 ]; then
    echo "Usage: "`basename $0`" <dbName> <backupPath>"
    exit 1
fi

LOG_FILE="$BACKUP_PATH/log/backup-$DB_NAME.log"
touch $LOG_FILE

function formatted_date {
    date +\%Y-\%m-\%d_\%H:\%M:\%S
}

DATE=`formatted_date`
BACKUP_FILE=backup-$DB_NAME-$DATE.sql;

####

LAST_BACKUP=`ls -t $BACKUP_PATH/backup*|head -n 1`;
echo "$DATE - Daily backup $DB_NAME started" >> $LOG_FILE
mv $LAST_BACKUP $BACKUP_PATH/archive;
gunzip $BACKUP_PATH/archive/*.gz 2> >(tee -a $LOG_FILE >&2)
xz -9 $BACKUP_PATH/archive/*.sql 2> >(tee -a $LOG_FILE >&2)
rm -f $BACKUP_PATH/yesterday/backup*.sql.gz;
mv $BACKUP_PATH/backup*.sql.gz $BACKUP_PATH/yesterday/;

END_DATE=`formatted_date`
echo "$END_DATE - Daily backup $DB_NAME finished" >> $LOG_FILE