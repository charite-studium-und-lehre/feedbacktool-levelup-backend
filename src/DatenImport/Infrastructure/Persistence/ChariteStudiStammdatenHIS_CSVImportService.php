<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\StudiStammdatenImportService;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\Nachname;
use Studi\Domain\StudiData;
use Studi\Domain\Vorname;

class ChariteStudiStammdatenHIS_CSVImportService extends AbstractCSVImportService implements StudiStammdatenImportService
{

    /** @return StudiData[] */
    public function getStudiData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    ): array {
        $studiDataObjects = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {
            $matrikelnummer = Matrikelnummer::fromInt($dataLine[0]);
            $vorname = Vorname::fromString($dataLine[1]);
            $nachname = Nachname::fromString($dataLine[2]);
            $geburtsdatum = Geburtsdatum::fromStringDeutschMinus($dataLine[3]);

            $studiDataObjects[] = StudiData::fromValues(
                $matrikelnummer,
                $vorname,
                $nachname,
                $geburtsdatum
            );
        }

        return $studiDataObjects;
    }
}