#!/bin/bash

# If anything goes wrong, exit and do not continue
set -e
set -o pipefail


DB_NAME=$1
BACKUP_PATH=$2/$1
IGNORE_TABLES=$3

if [ -z $2 ]; then
    echo "Usage: "`basename $0`" <dbName> <backupPath> [ignore_tables]"
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

SOFTLINK=latest_backup-$DB_NAME.sql.gz

echo "$DATE - Hourly backup $DB_NAME started" >> $LOG_FILE

if [ -z $IGNORE_TABLES ]; then
    mysqldump $DB_NAME > $BACKUP_PATH/$BACKUP_FILE  2> >(tee -a $LOG_FILE >&2)
else
    # Do not backup some tables
    IGNORE_TABLE_PARAMS=`echo ,$IGNORE_TABLES| sed -e "s/,/ --ignore-table=$DB_NAME./g"`

    mysqldump --add-drop-table --no-data $DB_NAME > $BACKUP_PATH/$BACKUP_FILE  2> >(tee -a $LOG_FILE >&2)
    mysqldump --no-create-info $DB_NAME $IGNORE_TABLE_PARAMS >> $BACKUP_PATH/$BACKUP_FILE 2> >(tee -a $LOG_FILE >&2)
fi

gzip $BACKUP_PATH/$BACKUP_FILE 2> >(tee -a $LOG_FILE >&2)
rm -f $BACKUP_PATH/$SOFTLINK
ln -s $BACKUP_PATH/$BACKUP_FILE.gz $BACKUP_PATH/$SOFTLINK

END_DATE=`formatted_date`
echo "$END_DATE - Hourly backup $DB_NAME finished" >> $LOG_FILE