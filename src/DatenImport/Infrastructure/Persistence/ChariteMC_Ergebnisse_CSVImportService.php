<?php

namespace DatenImport\Infrastructure\Persistence;

use Cluster\Domain\ClusterTitel;
use DatenImport\Domain\McPruefungsdatenImportService;
use Pruefung\Domain\PruefungsItemId;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Studi\Domain\StudiData;
use Wertung\Domain\Wertung\Punktzahl;

class ChariteMC_Ergebnisse_CSVImportService extends AbstractCSVImportService implements McPruefungsdatenImportService
{
    const ITEM_ID_PREFIX_OPTION = "ITEM_ID_PREFIX";
    const ITEM_ID_PREFIX_DEFAULT = "";

    private $itemIdPrefix;

    public function __construct($options = []) {
        $options[AbstractCSVImportService::HAS_HEADERS_OPTION] = TRUE;
        $this->itemIdPrefix = !empty($options[self::ITEM_ID_PREFIX_OPTION])
            ? $options[self::ITEM_ID_PREFIX_OPTION]
            : self:: ITEM_ID_PREFIX_DEFAULT;

        parent::__construct($options);
    }

    /** @return StudiData[] */
    public function getMCData(): array {
        $data = [];

        foreach ($this->getCSVDataAsArray() as $dataLine) {
            $matrikelnummer = Matrikelnummer::fromInt($dataLine["matrikel"]);
            $punktzahl = Punktzahl::fromFloat(max(0, $dataLine["richtig"]));
            $pruefungsItemId = PruefungsItemId::fromInt($this->itemIdPrefix . $dataLine["FragenNr"]);
            $clusterTitel = $dataLine["LZFach"] ? ClusterTitel::fromString($dataLine["LZFach"]) : NULL;

            $data[] = [
                $matrikelnummer,
                $punktzahl,
                $pruefungsItemId,
                $clusterTitel,
            ];
        }

        return $data;
    }

}