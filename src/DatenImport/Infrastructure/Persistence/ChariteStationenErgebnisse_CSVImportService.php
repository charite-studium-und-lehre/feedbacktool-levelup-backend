<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\McPruefungsdatenImportService;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\MatrikelnummerMitStudiHash;

class ChariteStationenErgebnisse_CSVImportService extends AbstractCSVImportService implements McPruefungsdatenImportService
{
    const ITEM_ID_PREFIX_OPTION = "ITEM_ID_PREFIX";
    const ITEM_ID_PREFIX_DEFAULT = "";

    private $itemIdPrefix;

    public function __construct($options = []) {
        $options[AbstractCSVImportService::HAS_HEADERS_OPTION] = TRUE;
        $this->itemIdPrefix = !empty($options[self::ITEM_ID_PREFIX_OPTION])
            ? $options[self::ITEM_ID_PREFIX_OPTION]
            : self::ITEM_ID_PREFIX_DEFAULT;

        parent::__construct($options);
    }

    public function getData(?PruefungsId $pruefungsId = NULL): array {
        $data = [];

        foreach ($this->getCSVDataAsArray() as $dataLine) {

            $ergebnisse = [];
            foreach ($dataLine as $key => $dataCell) {
                $ergebnis = str_replace(",", ".", $dataCell);
                if ((strstr($key, "#") !== FALSE
                        || in_array($key, ["Skala1_erg", "Skala2_erg"]))
                    && is_numeric($ergebnis)
                    && $ergebnis > 0) {

                    $ergebnisse[$key] = $ergebnis;
                }
            }

            $matrikelnummer = Matrikelnummer::fromInt($dataLine["matrikel"]);
            $resultLine = [
                "matrikelnummer" => $matrikelnummer,
                "ergebnisse"     => $ergebnisse,
            ];

            $resultLine["fach"] = !empty($dataLine["Fach"])
                ? $dataLine["Fach"]
                : NULL;

            $resultLine["datum"] = !empty($dataLine["Datum"])
                ? \DateTimeImmutable::createFromFormat("d.m.Y", $dataLine["Datum"])
                : NULL;

            $resultLine["pruefungsCode"] = !empty($dataLine["HIS"])
                ? $dataLine["HIS"]
                : NULL;

            $data[] = $resultLine;

        }

        return $data;
    }

}