<?php

namespace DatenImport\Infrastructure\Persistence;

use Cluster\Domain\ClusterTitel;
use Studi\Domain\MatrikelnummerMitStudiHash;

class ChariteLernzielModulImportCSVService extends AbstractCSVImportService
{
    public function __construct($options = []) {
        $options[AbstractCSVImportService::HAS_HEADERS_OPTION] = TRUE;

        parent::__construct($options);
    }

    /** return Array<int, ClusterTitel>
     *  returns <lernzielNummer => ClusterTitel(modulCode) >
     */
    public function getLernzielZuModulData(): array {
        $data = [];

        foreach ($this->getCSVDataAsArray() as $dataLine) {
            $lernzielNummer = (int) $dataLine["lernzielNummer"];
            $modulCode = ClusterTitel::fromString($dataLine["modulNummer"]);

            $data[$lernzielNummer] = $modulCode;
        }

        return $data;
    }

}