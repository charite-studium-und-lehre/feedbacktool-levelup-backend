<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\StudiStammdatenImportService;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\Nachname;
use Studi\Domain\StudiData;
use Studi\Domain\Vorname;

class StudiStammdatenHIS_CSVImportService implements StudiStammdatenImportService
{

    /** @return StudiData[] */
    public function getStudiData(array $importSettings = []): array {
        $inputFile = $importSettings["inputFile"];
        if (!$inputFile) {
            throw new \Exception("inputFile must be given");
        }
        $studiDataObjects = [];

        foreach ($this->getCSVDataAsArray($inputFile) as $dataLine) {
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

    private function getCSVDataAsArray(string $inputfile): array {
        $handle = fopen($inputfile, "r");

        $dataAsArray = NULL;
        while (($dataLine = fgetcsv($handle, NULL, ";")) !== FALSE) {
            $dataLineAngepasst = [];
            foreach ($dataLine as $dataCell) {
                $dataLineAngepasst[] = iconv("ISO-8859-15", "UTF-8",
                                             trim($dataCell)
                );
            }
            $dataAsArray[] = $dataLineAngepasst;
        }

        return $dataAsArray;
    }
}