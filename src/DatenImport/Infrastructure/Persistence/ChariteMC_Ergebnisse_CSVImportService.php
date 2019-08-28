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
    /** @var PruefungsId */
    private $pruefungsId;

    public function __construct($options = []) {
        $options[AbstractCSVImportService::HAS_HEADERS_OPTION] = TRUE;
        parent::__construct($options);
        $this->pruefungsId = $this->computeFileNameToPruefungsId($this->getInputFile());
    }

    public function getData(?PruefungsId $pruefungsId = NULL): array {
        $data = [];

        foreach ($this->getCSVDataAsArray() as $dataLine) {
            $matrikelnummer = Matrikelnummer::fromInt($dataLine["matrikel"]);
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

    public function getPruefungsId(): PruefungsId {
        return $this->pruefungsId;
    }

    private function computeFileNameToPruefungsId(string $filename): PruefungsId {
        $filename = basename($filename);
        $semester = substr(explode("_", $filename)[1], 0, 8);
        $durchlauf = substr(explode("_", $filename)[2], 0, 1);

        return PruefungsId::fromString("MC-$semester-$durchlauf");
    }

}