#!/bin/bash

zcat /home/levelup_data_import/exportFuerExternenServer.sql.gz | mysql levelup
SQL1='INSERT INTO studi(studiHash) (SELECT studiTmp.studiHash FROM studiTmp LEFT JOIN studi AS studiJoin ON studiJoin.studiHash = studiTmp.studiHash WHERE studiJoin.studiHash IS NULL);'
SQL2='DELETE studi FROM studi LEFT JOIN studiTmp ON studi.studiHash = studiTmp.studiHash WHERE studiTmp.studiHash IS NULL;'
SQL3='DROP TABLE studiTmp;'
echo "$SQL1 $SQL2 $SQL3"| mysql levelup
