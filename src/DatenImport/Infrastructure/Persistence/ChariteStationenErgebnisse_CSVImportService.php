<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\PruefungsdatenImportService;
use DateTimeImmutable;
use Exception;
use Pruefung\Domain\FachCodeKonstanten;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;

class ChariteStationenErgebnisse_CSVImportService extends AbstractCSVImportService implements PruefungsdatenImportService
{
    /** @return array<int, array<string,mixed>> */
    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {

            if (isset($dataLine["matrikel"])) {
                $matrikel = $dataLine["matrikel"];
            } elseif (isset($dataLine["matr"])) {
                $matrikel = $dataLine["matr"];
            } elseif (isset($dataLine["mat"])) {
                $matrikel = $dataLine["mat"];
            } else {
                throw new Exception("Keine Spalte 'matrikel' gefunden!");
            }
            if (!$matrikel) {
                continue;
            }
            $matrikelnummer = Matrikelnummer::fromInt((int) $matrikel);

            $ergebnisse = [];
            foreach ($dataLine as $key => $dataCell) {
                $ergebnis = str_replace(",", ".", $dataCell);
                if ((
                    (strstr($key, "#") !== FALSE || strstr($key, "X") !== FALSE)
                        || in_array($key, ["Skala1_erg", "Skala2_erg", "skala1_proz", "skala2_proz",
                                           "ergebnis", "Proz", "SCORE", "Skala1"]))
                    && is_numeric($ergebnis)
                ) {
                    if ($ergebnis > 100) {
                        echo "Fehler bei Matr. $matrikel: Prozentzahl ist > 100: $ergebnis -> Überspringe\n";
                        continue;
                    }

                    if (in_array($key, ["Skala1_erg", "skala1_proz", "Skala1"])) {
                        $key = "Sk1";
                    } elseif (in_array($key, ["Skala2_erg", "skala2_proz", "Skala2"])) {
                        $key = "Sk2";
                    } elseif (in_array($key, ["ergebnis"])) {
                        $key = "erg";
                    } elseif (in_array($key, ["Proz", "SCORE"])) {
                        if (isset($dataLine["Perma"])) {
                            $key = $dataLine["Perma"];
                        } elseif (isset($dataLine["Permadummy"])) {
                            $key = $dataLine["Permadummy"];
                        } elseif (isset($dataLine["permakÃ.rzel"])) {
                            $key = $dataLine["permakÃ.rzel"];
                        } elseif (isset($dataLine["permakürzel"])) {
                            $key = $dataLine["permakürzel"];
                        } elseif (isset($dataLine["Permakürzel"])) {
                            $key = $dataLine["Permakürzel"];
                        } elseif (isset($dataLine["erg"])) {
                            $key = "erg";
                        } else {
                            throw new Exception("Kein Header wie 'Perma' oder 'Permakürzel' oder 'erg' gefunden!");
                        }
                    }
                    $ergebnisse[$key] = $ergebnis;
                }
            }

            $resultLine = [
                "matrikelnummer" => $matrikelnummer,
                "ergebnisse"     => $ergebnisse,
            ];

            $fach = isset($dataLine["Fach"]) ? $dataLine["Fach"] : NULL;
            if (!$fach) {
                $fach = isset($dataLine["HIS_Nr"]) ? $dataLine["HIS_Nr"] : NULL;
            }
            $fach = explode(" 1", $fach)[0];
            $fach = explode(" 2", $fach)[0];
            $resultLine["fach"] = $fach
                ? FachCodeKonstanten::STATION_VK_KURZEL[$fach]
                : "";

            $resultLine["datum"] = !empty($dataLine["Datum"])
                ? DateTimeImmutable::createFromFormat("d.m.Y", $dataLine["Datum"])
                : NULL;

            $resultLine["pruefungsCode"] = !empty($dataLine["HIS"])
                ? $dataLine["HIS"]
                : NULL;

            $data[] = $resultLine;

        }

        return $data;
    }

}