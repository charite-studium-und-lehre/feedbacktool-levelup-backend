<?php

namespace DatenImport\Infrastructure\Persistence;

use Cluster\Domain\ClusterTitel;
use Studi\Domain\MatrikelnummerMitStudiHash;

class ChariteLernzielModulImportCSVService extends AbstractCSVImportService
{

    /** return Array<int, ClusterTitel>
     *  returns <lernzielNummer => ClusterTitel(modulCode) >
     *
     * @param string $inputFile
     * @param string $delimiter
     * @param bool $hasHeaders
     * @param string $fromEncoding
     * @return array
     */
    public function getLernzielZuModulData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {
            $lernzielNummer = (int) $dataLine["lernzielNummer"];
            $modulCode = ClusterTitel::fromString($dataLine["modulNummer"]);

            $data[$lernzielNummer] = $modulCode;
        }

        return $data;
    }

}