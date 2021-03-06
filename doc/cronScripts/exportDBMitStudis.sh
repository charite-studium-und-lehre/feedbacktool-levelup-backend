#!/bin/bash

SQL1='DROP TABLE IF EXISTS studiTmp;CREATE TABLE `studiTmp` (`studiHash` varchar(100) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
SQL2='INSERT INTO studiTmp SELECT studiHash FROM studi_intern;'
echo "$SQL1 $SQL2" | mysql levelup_intern
mysqldump --add-drop-table --ignore-table=levelup_intern.studi_intern --ignore-table=levelup_intern.studi --ignore-table=levelup_intern.epa_selbstBewertung --ignore-table=levelup_intern.__event --ignore-table=levelup_intern.__tableAutoincrement --ignore-table=levelup_intern.epa_fremdBewertung_anfrage --ignore-table=levelup_intern.epa_fremdBewertung --ignore-table=levelup_intern.migration_versions levelup_intern | gzip > /home/levelup_data_export/exportFuerExternenServer.sql.gz
SQL3="DROP TABLE studiTmp";
echo "$SQL3" | mysql levelup_intern
