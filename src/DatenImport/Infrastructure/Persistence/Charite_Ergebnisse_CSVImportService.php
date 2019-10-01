<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\PruefungsdatenImportService;
use Pruefung\Domain\ItemSchwierigkeit;
use Pruefung\Domain\PruefungsPeriode;
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
        PruefungsPeriode $periode = NULL
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {
            $matrikelnummer = is_numeric($dataLine["matrikel"])
                ? Matrikelnummer::fromInt((int) $dataLine["matrikel"]) : NULL;
            if (!$matrikelnummer) {
                continue;
            }
            $punktzahl = Punktzahl::fromFloat($dataLine["richtig"]);

            if (!isset($dataLine["Kl_Nr"]) && !isset($dataLine["Kl_nr"])) {
                echo "\nKl_Nr nicht gesetzt.";
                print_r($dataLine);
                continue;
            }
            $pruefungSemester = isset($dataLine["Kl_Nr"]) ? $dataLine["Kl_Nr"] : $dataLine["Kl_nr"];
            if ($pruefungSemester == "3D-MC") {
                continue;
            } else {
                $pruefungSemester = str_replace("MC Semester ", "", "$pruefungSemester");
            }
            if (strstr($pruefungSemester, "Grundlagenfächer_S05") !== FALSE) {
                continue;
            }
            if (!is_numeric($pruefungSemester)) {
                echo "-$pruefungSemester";
                continue;
            }

            try {
                $pruefungsId = PruefungsId::fromPruefungsformatUndPeriode(
                    PruefungsFormat::getMC($pruefungSemester),
                    $periode
                );
            } catch (\Exception $e) {
                echo "- Fehler beim Import: Prüfungstitel (Sem): ".$dataLine["Kl_Nr"];
            }

            $fragenNr = $dataLine["FragenNr"];
            $pruefungsItemIdString = $pruefungsId->getValue() . "-" . $fragenNr;

            $pruefungsItemId = PruefungsItemId::fromString($pruefungsItemIdString);
            $lzNummer = is_numeric($dataLine["LZNummer"]) ? $dataLine["LZNummer"] : NULL;

            $fragenAnzahl = is_numeric($dataLine["fr_anz"]) ? $dataLine["fr_anz"] : NULL;
            $gesamtErreichtePunktzahl = is_numeric($dataLine["punkte"]) ? $dataLine["punkte"] : NULL;
            $bestehensGrenze = is_numeric($dataLine["best_gr"]) ? $dataLine["best_gr"] : NULL;
            $schwierigkeitsWert =  is_numeric($dataLine["p"]) ? $dataLine["p"] : NULL;
            $schwierigkeit = NULL;
            if ($schwierigkeitsWert < .4) {
                $schwierigkeit = ItemSchwierigkeit::SCHWIERIGKEIT_SCHWER;
            } elseif($schwierigkeitsWert > .8) {
                $schwierigkeit = ItemSchwierigkeit::SCHWIERIGKEIT_LEICHT;
            } elseif ($schwierigkeitsWert) {
                $schwierigkeit = ItemSchwierigkeit::SCHWIERIGKEIT_NORMAL;
            }

            $data[] = [
                $matrikelnummer,
                $punktzahl,
                $pruefungsId,
                $pruefungsItemId,
                $fragenNr,
                $lzNummer,
                $gesamtErreichtePunktzahl,
                $fragenAnzahl,
                $bestehensGrenze,
                $schwierigkeit,
            ];
        }

        return $data;
    }

}