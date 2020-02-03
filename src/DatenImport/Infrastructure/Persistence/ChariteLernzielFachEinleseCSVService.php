<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\LernzielFachDatenEinleseService;
use Pruefung\Domain\FachCodeKonstanten;
use Studi\Domain\MatrikelnummerMitStudiHash;

class ChariteLernzielFachEinleseCSVService extends AbstractCSVImportService implements LernzielFachDatenEinleseService
{

    /** @return array<int, string> */
    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {
            $lernzielNummer = (int) $dataLine["LZ_Nummer"];
            $fachCode = trim(substr($dataLine["fach1_id"], 0, 3));
            if (isset(FachCodeKonstanten::MC_FACH_ZUSAMMENFASSUNG[$fachCode])) {
                $fachCode = FachCodeKonstanten::MC_FACH_ZUSAMMENFASSUNG[$fachCode];
            }
            $data[$lernzielNummer] = $fachCode;
        }

        return $data;
    }
}