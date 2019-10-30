<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\ChariteFragenDTO;
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
            if (isset($dataLine["Kl_Bezeichnung"])) {
                if (strstr($dataLine["Kl_Bezeichnung"], "MC Semester ") == FALSE) {
                    continue;
                }
                $semester = substr($dataLine["Kl_Bezeichnung"], 12);

            } elseif (isset($dataLine["Kl_Name"])) {
                if (strstr($dataLine["Kl_Name"], "MC Semester ") == FALSE) {
                    continue;
                }
                $semester = substr($dataLine["Kl_Name"], 12);
            } elseif (isset($dataLine["Modulnr"])) {
                if (strstr($dataLine["Modulnr"], "S") === FALSE) {
                    continue;
                }
                $semester = str_replace("S", "", $dataLine["Modulnr"]);
            } elseif (isset($dataLine["Modulname"])) {
                $modulCode = substr($dataLine["Modulname"], 1, 2);
                if (!is_numeric($modulCode) || $modulCode >= 17) {
                    continue; // MSM2
                }
                $semester = ceil($modulCode / 4);
            }

            if (!$semester) {
                dump($dataLine);
                throw new \Exception("Kein Semester gefunden in Zeile:");
            }

            try {
                $pruefungsId = PruefungsId::fromPruefungsformatUndPeriode(
                    PruefungsFormat::getMC($semester),
                    $periode
                );
            } catch (Exception $e) {
                echo "- Fehler beim Import: Prüfungstitel (Sem): " . $dataLine["Kl_Nr"];
            }
            $fragenNr = isset($dataLine["FragenNr"]) ? $dataLine["FragenNr"] : $dataLine["fragenNr"];
            //            $lernzielNr = isset($dataLine["Lernziel"]) ? $dataLine["Lernziel"] : $dataLine["LernzielNr"];
            $fragenText = $dataLine["Fragentext"];
            $fragenText = str_replace('<$u>', '---', $fragenText);
            $fragenText = str_replace('<$/u>', '---', $fragenText);
            $fragenText = str_replace('<$sub>', '', $fragenText);
            $fragenText = str_replace('<$/sub>', '', $fragenText);


//            dump($dataLine);
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

    private
    function getAntworten(
        array $dataLine
    ) {
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
            $antwortString = $dataLine[$antwortHeader];
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