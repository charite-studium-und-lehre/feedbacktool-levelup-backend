<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\PruefungsdatenImportService;
use Pruefung\Domain\PruefungsDatum;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Wertung\Domain\Wertung\Punktzahl;

class Charite_Ergebnisse_CSVImportService extends AbstractCSVImportService implements PruefungsdatenImportService
{
    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING,
        PruefungsDatum $datum = NULL
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {
            $matrikelnummer = is_numeric($dataLine["matrikel"])
                ? Matrikelnummer::fromInt((int) $dataLine["matrikel"]) : NULL;
            if (!$matrikelnummer) {
                continue;
            }
            $punktzahl = Punktzahl::fromFloat(max(0, $dataLine["richtig"]));

            if (!isset($dataLine["Kl_Nr"]) && !isset($dataLine["Kl_nr"])) {
                echo "\nKl_Nr nicht gesetzt.";
                print_r($dataLine);
                continue;
            }
            $pruefungSemester = isset($dataLine["Kl_Nr"]) ? $dataLine["Kl_Nr"] : $dataLine["Kl_nr"];
            if ($pruefungSemester == "3D-MC") {
                $pruefungSemester = 3;
            } else {
                $pruefungSemester = str_replace("MC Semester ", "", "$pruefungSemester");
            }
            if (!is_numeric($pruefungSemester)) {
                if (strpos($pruefungSemester, "Modul ") === FALSE
                    && strpos($pruefungSemester, "Modul") === FALSE) {
                    echo "-$pruefungSemester";
                }
                continue;
            }

            try {
                $pruefungsId = PruefungsId::fromPruefungsformatUndDatum(
                    PruefungsFormat::getMC($pruefungSemester),
                    $datum
                );
            } catch (\Exception $e) {
                echo "- Fehler beim Import: Prüfungstitel (Sem): ".$dataLine["Kl_Nr"];
            }

            $pruefungsItemIdString = $pruefungsId->getValue() . "-" . $dataLine["FragenNr"];

            $pruefungsItemId = PruefungsItemId::fromString($pruefungsItemIdString);
            $lzNummer = is_numeric($dataLine["LernzielNr"]) ? $dataLine["LernzielNr"] : NULL;

            $data[] = [
                $matrikelnummer,
                $punktzahl,
                $pruefungsId,
                $pruefungsItemId,
                $lzNummer,
            ];
        }

        return $data;
    }

}