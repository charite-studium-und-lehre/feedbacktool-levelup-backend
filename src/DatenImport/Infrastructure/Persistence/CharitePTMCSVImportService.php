<?php

namespace DatenImport\Infrastructure\Persistence;

use Cluster\Domain\ClusterTyp;
use DatenImport\Domain\CharitePTMPersistenzService;
use Pruefung\Domain\FachCodeKonstanten;

class CharitePTMCSVImportService extends AbstractCSVImportService

{
    const ORGANSYSTEM_KUERZEL = [
        'hkl' => 'Herz- Kreislauf',
        'zel' => 'Genetik Zellmechanismen',
        'ver' => 'Verdauung',
        'hst' => 'Hormone Stoffwechsel',
        'blu' => 'Blut Lymphe Immun',
        'pso' => 'psychische Erkrankungen',
        'met' => 'Methodik Instrumente',
        'akl' => 'Allg. Krankheitslehre',
        'bew' => 'Bewegungsapparat',
        'ngs' => 'Nervensystem Gehirn Sinne',
        'ges' => 'Fortpflanzung',
        'atm' => 'Atmung',
        'hau' => 'Haut- Hautanhangsgebilde',
        'nha' => 'Niere Harnwege',
    ];

    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    ): array {
        $data = [];

        foreach ($this->getCSVDataAsArray($inputFile, $delimiter, $hasHeaders, $fromEncoding)
            as $dataLine) {

            $matrikelnummer = $dataLine["matnr"];
            foreach ($dataLine as $key => $ergebnis) {

                if ((strstr($key, "_") === FALSE) || !is_numeric($ergebnis)) {
                    continue;
                }

                $kuerzel = trim(explode("_", $key)[0]);

                if (array_key_exists($kuerzel, FachCodeKonstanten::PTM_FACH_KUERZEL)) {
                    $clusterTyp = ClusterTyp::getFachTyp()->getConst();
                    $ptmClusterKuerzel = $kuerzel;
                } elseif (array_key_exists($kuerzel, self::ORGANSYSTEM_KUERZEL)) {
                    continue;
                    $clusterTyp = ClusterTyp::getOrgansystemTyp()->getConst();
                    $ptmClusterKuerzel = $kuerzel;
                } elseif ($kuerzel == "all") {
                    $clusterTyp = "gesamtergebnis";
                    $ptmClusterKuerzel = $kuerzel;
                } else {
                    continue;
                }

                $bewertungsTyp = explode("_", $key)[1];
                if (!in_array($bewertungsTyp, [CharitePTMPersistenzService::TYP_RICHTIG,
                                               CharitePTMPersistenzService::TYP_FALSCH,
                                               CharitePTMPersistenzService::TYP_WEISSNICHT])) {
                    continue;
                }
                $data[$matrikelnummer][$clusterTyp][$ptmClusterKuerzel][$bewertungsTyp] = $ergebnis;
            }
        }

        return $data;
    }

}