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
            try {
                $matrikelnummer = Matrikelnummer::fromInt($dataLine["mtknr"]);
            } catch (\InvalidArgumentException $e) {
                echo "Fehler: " . $e->getMessage() . " -> Ignoriere Eintrag;\n";
                continue;
            }

            $vorname = Vorname::fromString($dataLine["vorname"]);
            $nachname = Nachname::fromString($dataLine["nachname"]);
            $geburtsdatum = Geburtsdatum::fromStringDeutschMinus($dataLine["gebdat"]);

            $studiDataObjects[] = StudiData::fromValues(
                $matrikelnummer,
                $vorname,
                $nachname,
                $geburtsdatum,
                $dataLine
            );
        }

        return $studiDataObjects;
    }
}