<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\McPruefungsdatenImportService;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Wertung\Domain\Wertung\Punktzahl;

class ChariteMC_Ergebnisse_CSVImportService extends AbstractCSVImportService implements McPruefungsdatenImportService
{
    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING,
        ?PruefungsId $pruefungsId = NULL
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {
            $matrikelnummer = is_numeric($dataLine["matrikel"])
                ? Matrikelnummer::fromInt($dataLine["matrikel"]) : NULL;
            if (!$matrikelnummer) {
                continue;
            }
            $punktzahl = Punktzahl::fromFloat(max(0, $dataLine["richtig"]));

            $pruefungsItemIdString = $pruefungsId->getValue() . "-" . $dataLine["FragenNr"];

            $pruefungsItemIdString = PruefungsItemId::fromString($pruefungsItemIdString);
            $lzNummer = is_numeric($dataLine["LernzielNr"]) ? $dataLine["LernzielNr"] : NULL;

            $data[] = [
                $matrikelnummer,
                $punktzahl,
                $pruefungsItemIdString,
                $lzNummer,
            ];
        }

        return $data;
    }

}