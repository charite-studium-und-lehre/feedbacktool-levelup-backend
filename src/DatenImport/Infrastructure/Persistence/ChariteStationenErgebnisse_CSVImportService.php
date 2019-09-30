<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\FachCodeKonstanten;
use DatenImport\Domain\PruefungsdatenImportService;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;

class ChariteStationenErgebnisse_CSVImportService extends AbstractCSVImportService implements PruefungsdatenImportService
{
    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {

            $ergebnisse = [];
            foreach ($dataLine as $key => $dataCell) {
                $ergebnis = str_replace(",", ".", $dataCell);
                if ((strstr($key, "#") !== FALSE
                        || in_array($key, ["Skala1_erg", "Skala2_erg"]))
                    && is_numeric($ergebnis)
                    && $ergebnis > 0) {

                    if ($key == "Skala1_erg") {
                        $key = "Sk1";
                    }
                    if ($key == "Skala2_erg") {
                        $key = "Sk2";
                    }

                    $ergebnisse[$key] = $ergebnis;
                }
            }

            if (isset($dataLine["matrikel"])) {
                $matrikel = $dataLine["matrikel"];
            } elseif (isset($dataLine["matr"])) {
                $matrikel = $dataLine["matr"];
            } else {
                throw new \Exception("Keine Spalte 'matrikel' gefunden!");
            }
            $matrikelnummer = Matrikelnummer::fromInt((int) $matrikel);
            $resultLine = [
                "matrikelnummer" => $matrikelnummer,
                "ergebnisse"     => $ergebnisse,
            ];

            $resultLine["fach"] = !empty($dataLine["Fach"])
                ? array_flip(FachCodeKonstanten::STATION_VK_KURZEL)[$dataLine["Fach"]]
                : "";

            $resultLine["datum"] = !empty($dataLine["Datum"])
                ? \DateTimeImmutable::createFromFormat("d.m.Y", $dataLine["Datum"])
                : NULL;

            $resultLine["pruefungsCode"] = !empty($dataLine["HIS"])
                ? $dataLine["HIS"]
                : NULL;

            $data[] = $resultLine;

        }

        return $data;
    }

}