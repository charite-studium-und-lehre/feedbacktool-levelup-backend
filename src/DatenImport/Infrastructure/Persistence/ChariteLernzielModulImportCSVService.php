<?php

namespace DatenImport\Infrastructure\Persistence;

use Cluster\Domain\ClusterCode;
use Studi\Domain\MatrikelnummerMitStudiHash;

class ChariteLernzielModulImportCSVService extends AbstractCSVImportService
{

    /**
     * returns <lernzielNummer => ClusterTitel(modulCode) >
     *
     * @return array<int, ClusterCode>
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
            $modulCode = ClusterCode::fromString($dataLine["modulNummer"]);

            $data[$lernzielNummer] = $modulCode;
        }

        return $data;
    }

}