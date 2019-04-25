<?php

namespace DatenImport\Infrastructure\Persistence;

use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\Nachname;
use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\Studi;
use Studi\Domain\Vorname;

class StudiStammdatenCSVImportService
{
    /** @var StudiHashCreator */
    private $studiHashCreator;

    public function __construct(StudiHashCreator $studiHashCreator) {
        $this->studiHashCreator = $studiHashCreator;
    }

    /** @return Studi[] */
    public function getStudiObjects(string $inputfile): array {
        $studiHashArray = [];

        foreach ($this->getCSVDataAsArray($inputfile) as $dataLine) {
            $matrikelnummer = Matrikelnummer::fromInt($dataLine[0]);
            $vorname = Vorname::fromString($dataLine[1]);
            $nachname = Nachname::fromString($dataLine[2]);
            $geburtsdatum = Geburtsdatum::fromStringDeutschMinus($dataLine[3]);

            $studiHashArray[] = $this->studiHashCreator->createStudiHash(
                $matrikelnummer,
                $vorname,
                $nachname,
                $geburtsdatum
            );
        }

        return $studiHashArray;
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