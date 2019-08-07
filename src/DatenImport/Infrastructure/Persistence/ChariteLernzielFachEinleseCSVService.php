<?php

namespace DatenImport\Infrastructure\Persistence;

use Cluster\Domain\ClusterTitel;
use DatenImport\Domain\FachCodeKonstanten;
use DatenImport\Domain\LernzielFachDatenEinleseService;
use DatenImport\Domain\McPruefungsdatenImportService;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItemId;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;
use Wertung\Domain\Wertung\Punktzahl;

class ChariteLernzielFachEinleseCSVService extends AbstractCSVImportService implements LernzielFachDatenEinleseService
{
    public function __construct($options = []) {
        $options[AbstractCSVImportService::HAS_HEADERS_OPTION] = TRUE;
        $options[AbstractCSVImportService::FROM_ENCODING_OPTION] = "ISO-8859-15";
        parent::__construct($options);
    }

    public function getData(): array {
        $data = [];

        foreach ($this->getCSVDataAsArray() as $dataLine) {
            $lernzielNummer = $dataLine["LZ_Nummer"];
            $fachCode = trim(substr($dataLine["fach1_id"], 0, 3));
            if (isset( FachCodeKonstanten::MC_FACH_ZUSAMMENFASSUNG[$fachCode])) {
                $fachCode = FachCodeKonstanten::MC_FACH_ZUSAMMENFASSUNG[$fachCode];
            }
            $data[$lernzielNummer] = $fachCode;
        }

        return $data;
    }
}