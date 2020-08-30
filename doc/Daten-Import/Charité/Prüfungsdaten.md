# Prüfungsdaten

* Werden vom Prüfungsbereich manuell auf `s-mfal-feed-int` hochgeladen
* Username: "upload"
* Ergebnis in `/home/upload`

Testdaten in: [ImportServices](../../../tests/Integration/DatenImport/Infrastructure/ImportServices) 

Skript zum Import aller Prüfungsdaten: [levelupImportCommands.sh](../../../levelupImportCommands.sh) 

### Neue Prüfung integrieren

Es gibt eine neue .xls oder .xlsx-Datei in /Upload

0. Finden von neuen Dateien aus den letzten 90 Tagen:
    (Hier am Beispiel von MC, analog für andere Prüfungen)

    ```
    cd /home/upload/MC
    find -ctime -90
    ```

1. ##### Kopieren nach /data01/uploadData
   

**Warum?** Wir wollen auf einem eigenen Verzeichnis arbeiten, das der Prüfungsbereich nicht sieht.

   ```shell script
   cp /home/upload/MC/<Datei> /data01/uploadData/MC
   ```



2. ##### Umwandeln in .csv

   **Einzelne Datei**:

   ```shell script
   cd /data01/uploadData/MC
   xlsx2csv <Datei1> <Datei2>
   # z.B. xlsx2csv gesamtergebnisse_WiSe1819_T2_qs.xlsx gesamtergebnisse_WiSe1819_T2_qs.xlsx.csv
   ```

   **Alle Dateien im Verzeichnis gleichzeitig**

   Dazu gibt es ein Skript in `/data01/uploadData/convertAllFiles`:

   ```shell script
   #!/bin/bash
   find -iname "*.xlsx" -exec echo {} \; -exec xlsx2csv {} {}.csv \;
   ```

   -> Wandelt alle Dateien im aktuellen Verzeichnis und darunter um

3. ##### Neues Kommando erstellen lokal im Backend-Code, branch **master** in Datei [levelupImportCommands.sh](../../../levelupImportCommands.sh) 

   1. Semester bestimmen: z.B. SoSe2019 = 20191, WiSe2019/20 = 20192
   2. Prüfungsperiode (nicht bei PTM): 1(1. Termin) -> "1" anhängen; 2 (2. Termin) -> 2 anhängen
   3. Kommando erzeugen (**siehe unten "Import nach Prüfungsformat"**):

   ```shell script
   cd /var/www/levelup-backend/
   sudo bin/console levelup:importFile:mcCSVWertung $BASE_LEVELUP_IMPORT_DIR/MC/gesamtergebnisse_SoSe_19_T2_qs.xlsx.csv 201912
   ```

   4. Testen, ob Datei importiert werden kann. Das kann direkt auf dem Server getestet werden (als root).

      Dies darf keine Fehler ergeben.

4. ##### Hinzufügen des Kommandos zu  [levelupImportCommands.sh](../../../levelupImportCommands.sh) 

5. ##### Wenn für alle Dateien und Commands fertig: 
   
   Push & Deploy



## Deployment des angepassten Skripts

```shell script
# auf internem Server
cd /var/www/levelup-backend/
git pull --rebase
```



## Import nach Prüfungsformat

1. ##### MC

   Es sind 3 Importe pro Prüfungstermin nötig:

   1. *levelup:importFile:mcCSVWertung*
      -> mit CSV-Datei "gesamtergebnisse"
   2. *levelup:importFile:mcCSVFachUndModule*
      -> mit CSV-Datei "gesamtergebnisse"
   3. *levelup:importFile:mcFragenTexte*
      -> mit CSV-Datei in /FragenTexte

2. ##### PTM

   Im PTM gibt es nur eine Datei und ein Kommando

   1. *levelup:importFile:ptm*

3. **Stationsprüfungen**
   Es gibt 5 Arten von Stationsprüfungen. Deshalb gibt es nach dem Zeitsemester hier einen zusätzlichen Parameter:

   1. ***Teil1VK***
      *Synonyme:* 
      * Teil 1 Vorklinik
      * Teil 1 Grundlagen
   2. ***Teil1K***
      *Synonyme:*  
      * Teil 1 Klinik 
      * OSCE 2
   3. ***Teil2***
      *Synonyme:* Teil 2 Grundlagen
   4. ***Teil3***
      Synonym: OSCE 4
   5. ***Sem9***
      Synonym: OSCE 9

   Die richtige Datei für einen Typ enthält mindestens einen der Synonyme. Hier muss man also manuell die richtige Datei finden und zuordnen.

   

## Wann sehe ich es im Frontend?

1. jede Nacht wird der Import auf dem internem Server ausgeführt. Das kann bis zu 24 Stunden dauern...
2. In der folgenden Nacht wird die DB vom internen Server auf den externen Server (frontend) kopiert.

Danach (nach 2 Nächten) sieht man die Daten im Frontend.

##### Kann ich das beschleunigen?

Ja.

1. Man lässt die Skripte manuell bis zu  Ende laufen (1. Tag gespart)

   Import unbedingt mit *screen* ausführen, siehe https://wiki.ubuntuusers.de/Screen/

2. Man kann die Daten sofort auf den externen Server (frontend) kopieren (2. Tag gespart):

   1. auf internem Server:

      ```shell script
      # als root:
      /var/www/levelup-backend/doc/cronScripts/exportDBMitStudis.sh
      
      # als Benutzer "levelup_data_export"
      sudo su - levelup_data_export
      scp /home/levelup_data_export/exportFuerExternenServer.sql.gz levelup_data_import@s-mfal-feed-ext:
      ```

   2. auf externem Server:

      ```shell script
      # als root
      /var/www/levelup-backend/master/doc/cronScripts/importDBMitStudis.sh
      ```

      

## Ich habe falsche Daten importiert

Diese Daten können pro Semester aus der internen DB gelöscht werden.

Wichtig ist, die Semester-Variable auf das zu löschende Semester zu setzen, z.B. 20202 für das WiSe2020

##### Importierte Daten anzeigen:

```mysql
SET @SEMESTER="%20112%";

SELECT * FROM pruefung_studiPruefungsWertung INNER JOIN pruefung_studiPruefung ON pruefung_studiPruefungsWertung.studiPruefungsId = pruefung_studiPruefung.id WHERE pruefungsId LIKE @SEMESTER;
SELECT * FROM pruefung_studiPruefung WHERE pruefungsId LIKE @SEMESTER;

SELECT * FROM pruefung_frage WHERE pruefungsItemId LIKE @SEMESTER;
SELECT * FROM pruefung_frage_antwort WHERE fragenId LIKE @SEMESTER;

SELECT * FROM pruefung_itemWertung WHERE pruefungsItemId LIKE @SEMESTER;
SELECT * FROM pruefung_item WHERE pruefungsId LIKE @SEMESTER;
SELECT * FROM pruefung WHERE pruefungsPeriode LIKE @SEMESTER;
```

##### Importierte Daten löschen

```mysql
SET @SEMESTER="%20202%";

DELETE pruefung_studiPruefungsWertung FROM pruefung_studiPruefungsWertung INNER JOIN pruefung_studiPruefung ON pruefung_studiPruefungsWertung.studiPruefungsId = pruefung_studiPruefung.id WHERE pruefungsId LIKE @SEMESTER;
DELETE FROM pruefung_studiPruefung WHERE pruefungsId LIKE @SEMESTER;

DELETE FROM pruefung_frage WHERE pruefungsItemId LIKE @SEMESTER;
DELETE FROM pruefung_frage_antwort WHERE fragenId LIKE @SEMESTER;

DELETE FROM pruefung_itemWertung WHERE pruefungsItemId LIKE @SEMESTER;
DELETE FROM pruefung_item WHERE pruefungsId LIKE @SEMESTER;
DELETE FROM pruefung WHERE pruefungsPeriode LIKE @SEMESTER;
```

### Troubleshooting

```
In ChariteStationsClusterungPersistenzService.php line 73:
                                  
  [ErrorException]                
  Notice: Undefined index: 27#03  
```

Der angegebene Code (hier 27#03) ist nicht bekannt.  Er muss im Quellcode in der Datei [FachCodeKonstanten.php](../../../src/Pruefung/Domain/FachCodeKonstanten.php)  hinzugefügt werden

### Statische Dateien aktualisieren

Damit der Import richtig läuft, müssen einmal pro Semester die Lernziele aktualisiert werden.

Die Export sind unter 

https://lernziele.charite.de/zend/export/exportquery/id/33

und 

https://lernziele.charite.de/zend/export/exportquery/id/34

Dies müssen auf dem Server an folgende Orte gelegt werden:

`$BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv`

und 

`$BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Fach.csv`

also z.B. als root:

```shell script
cp /tmp/LEVELUP-Lernziel-Module.csv $BASE_LEVELUP_IMPORT_DIR/LEVELUP-Lernziel-Module.csv
cp /tmp/LEVELUP-Lernziel-Fach.csv /data01/uploadData//LEVELUP-Lernziel-Fach.csv
```

