<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\PruefungsdatenImportService;
use Exception;
use Pruefung\Domain\FrageAntwort\AntwortCode;
use Pruefung\Domain\FrageAntwort\FragenNummer;
use Pruefung\Domain\ItemSchwierigkeit;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;
use Pruefung\Domain\PruefungsPeriode;
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

            $pruefungSemester = isset($dataLine["Kl_Nr"])
                ? $dataLine["Kl_Nr"]
                : (isset($dataLine["Kl_nr"])
                    ? $dataLine["Kl_nr"]
                    : $dataLine["Klausur"]
                );
            if (!$pruefungSemester) {
                echo "\nKl_Nr oder Klausur nicht gesetzt.";
                print_r($dataLine);
                continue;
            }

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
            } catch (Exception $e) {
                echo "- Fehler beim Import: Prüfungstitel (Sem): " . $dataLine["Kl_Nr"];
            }

            $fragenNr = $dataLine["FragenNr"];

            $pruefungsItemId = PruefungsItemId::fromPruefungsIdUndFragenNummer(
                $pruefungsId, FragenNummer::fromInt($fragenNr)
            );

            $lzNummer = isset($dataLine["LZNummer"]) ? $dataLine["LZNummer"] : $dataLine["LZnummer"];
            if (is_numeric($lzNummer)) {
                $lzNummer = (int) $lzNummer;
            } else {
                $lzNummer = NULL;
            }

            $fragenAnzahl = is_numeric($dataLine["fr_anz"]) ? $dataLine["fr_anz"] : NULL;
            $gesamtErreichtePunktzahl = is_numeric($dataLine["punkte"]) ? $dataLine["punkte"] : NULL;
            $bestehensGrenze = is_numeric($dataLine["best_gr"]) ? $dataLine["best_gr"] : NULL;
            $schwierigkeitsWert = is_numeric($dataLine["p"]) ? $dataLine["p"] : NULL;
            $schwierigkeit = NULL;
            if ($schwierigkeitsWert < .4) {
                $schwierigkeit = ItemSchwierigkeit::SCHWIERIGKEIT_SCHWER;
            } elseif ($schwierigkeitsWert > .8) {
                $schwierigkeit = ItemSchwierigkeit::SCHWIERIGKEIT_LEICHT;
            } elseif ($schwierigkeitsWert) {
                $schwierigkeit = ItemSchwierigkeit::SCHWIERIGKEIT_NORMAL;
            }

            $antwortCode = isset($dataLine["antwort"]) ? AntwortCode::fromString($dataLine["antwort"]) : NULL;

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
                $antwortCode,
            ];
        }

        return $data;
    }

}