# Prüfungsdaten

* Werden vom Prüfungsbereich manuell auf //s-mfal-feed-int// hochgeladen
* Username: "upload"
* Ergebnis in [[/home/upload]]
* Ergebnis wird jede Nacht verschoben nach [[/var/lib/uploadData]

Testdaten in: [ImportServices](../../../tests/Integration/DatenImport/Infrastructure/ImportServices) 

Skript zum Import aller Prüfungsdaten: [levelupImportCommands.sh](../../../levelupImportCommands.sh) 

### Neue Prüfung integrieren

Es gibt eine neue .xls oder .xlsx-Datei in /Upload

0. Finden von neuen Dateien aus den letzten 90 Tagen:

   ```
   cd /data01/uploadData/MC
   find -ctime -90
   ```

1. Umwandeln in .csv

   Dazu gibt es ein Skript in `/data01/uploadData/convertAllFiles`:

   ```shell script
   #!/bin/bash
   find -iname "*.xlsx" -exec echo {} \; -exec xlsx2csv {} {}.csv \;
   ```

   -> Wandelt alle Dateien im aktuellen Verzeichnis und darunter um

   Einzelne Datei:

   ```shell script
   cd /data01/uploadData/MC
   xlsx2csv gesamtergebnisse_WiSe1819_T2_qs.xlsx gesamtergebnisse_WiSe1819_T2_qs.xlsx.csv
   ```

   

2. Testen, ob Datei importiert werden kann. Ein neues Kommando muss erstellt werden ähnlich wie in  [levelupImportCommands.sh](../../../levelupImportCommands.sh) 

   ```shell script
   cd /var/www/levelup-backend/
   sudo bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_19_T2_qs.xlsx.csv 201912
   ```

   Dies darf keine Fehler ergeben.

3. Hinzufügen des Kommandos zu  [levelupImportCommands.sh](../../../levelupImportCommands.sh) 

4. Push & Deploy

Fertig.






