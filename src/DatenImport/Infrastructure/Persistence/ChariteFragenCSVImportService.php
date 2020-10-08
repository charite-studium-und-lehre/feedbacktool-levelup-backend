<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\ChariteFragenDTO;
use Exception;
use Pruefung\Domain\FrageAntwort\AntwortCode;
use Pruefung\Domain\FrageAntwort\AntwortText;
use Pruefung\Domain\FrageAntwort\FragenNummer;
use Pruefung\Domain\FrageAntwort\FragenText;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsPeriode;

class ChariteFragenCSVImportService extends AbstractCSVImportService

{
    /** @return ChariteFragenDTO[] */
    public function getData(
        string $inputFile,
        PruefungsPeriode $periode,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {

            $semester = NULL;

            if (isset($dataLine["SequenzSemesterNummer"])) {
                $semester = (int) $dataLine["SequenzSemesterNummer"];
            } elseif (isset($dataLine["Kl_Bezeichnung"])) {
                if (strstr($dataLine["Kl_Bezeichnung"], "MC Semester ") == FALSE) {
                    continue;
                }
                $semester = (int) substr($dataLine["Kl_Bezeichnung"], 12);

            } elseif (isset($dataLine["Kl_Name"])) {
                if (strstr($dataLine["Kl_Name"], "MC Semester ") !== FALSE) {
                    $semester = (int) substr($dataLine["Kl_Name"], 12);
                } else if (strstr($dataLine["Kl_Name"], "Semesterabschlussprüfung S") !== FALSE) {
                    $semester = (int) substr($dataLine["Kl_Name"], 27);
                } else {
                    continue;
                }
            } elseif (isset($dataLine["Modulnr"])) {
                if (strstr($dataLine["Modulnr"], "S") === FALSE) {
                    continue;
                }
                $semester = (int) str_replace("S", "", $dataLine["Modulnr"]);
            } elseif (isset($dataLine["Modulname"]) || isset($dataLine["Modul"])) {
                $modulCode = isset($dataLine["Modulname"])
                    ? $dataLine["Modulname"]
                    : $dataLine["Modul"];
                $modulCode = substr($modulCode, 1, 2);
                if (!is_numeric($modulCode) || $modulCode >= 17) {
                    continue; // MSM2
                }
                $semester = (int) ceil($modulCode / 4);
                if ((int) $modulCode == 37) {
                    $semester = 9;
                }
            }

            if (!$semester) {
                dump($dataLine);
                throw new Exception("Kein Semester gefunden in Zeile:");
            }

            $pruefungsId = NULL;
            try {
                $pruefungsId = PruefungsId::fromPruefungsformatUndPeriode(
                    PruefungsFormat::getMC($semester),
                    $periode
                );
            } catch (Exception $e) {
                echo "- Fehler beim Erstellen der Prüfungs-ID: Fachsemester: $semester";
                throw $e;
            }
            $fragenNr = isset($dataLine["Fragennr"])
                ? $dataLine["Fragennr"]
                : (
                isset($dataLine["fragenNr"])
                    ? $dataLine["fragenNr"]
                    : $dataLine["FragenNr"]
                );
            if (!$fragenNr) {
                throw new Exception("Fragennr im Header nicht gefunden!");
            }
            //            $lernzielNr = isset($dataLine["Lernziel"]) ? $dataLine["Lernziel"] : $dataLine["LernzielNr"];
            $fragenText = $dataLine["Fragentext"];
            $fragenText = str_replace('<$u>', '---', $fragenText);
            $fragenText = str_replace('<$/u>', '---', $fragenText);
            $fragenText = str_replace('<$b>', '-', $fragenText);
            $fragenText = str_replace('<$/b>', '-', $fragenText);
            $fragenText = str_replace('<$sup>', '', $fragenText);
            $fragenText = str_replace('<$/sup>', '', $fragenText);
            $fragenText = str_replace('<$sub>', '', $fragenText);
            $fragenText = str_replace('<$/sub>', '', $fragenText);
            $fragenText = str_replace('<$i>', '"', $fragenText);
            $fragenText = str_replace('<$/i>', '"', $fragenText);
            $fragenText = str_replace('_x000D_', '', $fragenText);
            $fragenText = str_replace('_x005F', '_', $fragenText);

            $loesung = !empty($dataLine["Lösung"]) ? $dataLine["Lösung"] : "zzz";

            $fragenDTO = new ChariteFragenDTO();
            $fragenDTO->fragenNr = FragenNummer::fromInt($fragenNr);
            $fragenDTO->loesung = AntwortCode::fromString($loesung);
            $fragenDTO->semester = $semester;
            $fragenDTO->pruefungsId = $pruefungsId;
            $fragenDTO->fragenText = FragenText::fromInt($fragenText);
            $fragenDTO->antworten = $this->getAntworten($dataLine);
            $fragenDTO->mitAbbildung = $dataLine["Abbildung"] != "keine Abbildung.jpg";

            $data[] = $fragenDTO;
        }

        return $data;
    }

    /**
     * @param array<string, string> $dataLine
     * @return array<string, AntwortText>
     */
    private function getAntworten(array $dataLine): array {
        if (array_key_exists("Antwort_A", $dataLine)) {
            $antwortHeaderArray =
                ["Antwort_A", "Antwort_B", "Antwort_C", "Antwort_D", "Antwort_E", "Antwort_F", "Antwort_G",
                 "Antwort_H",];
        } elseif (array_key_exists("Antwort_1", $dataLine)) {
            $antwortHeaderArray =
                ["Antwort_1", "Antwort_2", "Antwort_3", "Antwort_4", "Antwort_5", "Antwort_6", "Antwort_7",
                 "Antwort_8",];
        } else {
            $antwortHeaderArray =
                ["Antwort1", "Antwort2", "Antwort3", "Antwort4", "Antwort5", "Antwort6", "Antwort7", "Antwort8",];
        }
        $returnArray = [];
        foreach ($antwortHeaderArray as $antwortHeader) {
            $antwortString = isset($dataLine[$antwortHeader]) ? $dataLine[$antwortHeader] : NULL;
            if (!$antwortString) {
                continue;
            }
            $antwortTextString = trim(substr($antwortString, 2));
            if (!$antwortTextString) {
                $antwortTextString = "--- Antwort nicht verfügbar ---";
            }
            $antwortCode = trim(substr($antwortString, 0, 1));
            if ($antwortCode == "#") {
                continue;
            }
            $antwortText = AntwortText::fromString($antwortTextString);
            $returnArray[$antwortCode] = $antwortText;
        }

        return $returnArray;
    }

}