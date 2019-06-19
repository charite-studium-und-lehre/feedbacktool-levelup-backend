<?php

namespace DatenImport\Infrastructure\Persistence;

use DatenImport\Domain\CharitePTMPersistenzService;

class CharitePTMCSVImportService extends AbstractCSVImportService

{
    const CLUSTER_ORGANSYSTEM = 10;
    const CLUSTER_FACH = 20;

    const ORGANSYSTEM_KUERZEL = [
        'hkl' => 'Herz- Kreislauf',
        'zel' => 'Genetik Zellmechanismen',
        'ver' => 'Verdauung',
        'hst' => 'Hormone Stoffwechsel',
        'blu' => 'Blut Lymphe Immun',
        'pso' => 'psychische Erkrankungen',
        'met' => 'Methodik Instrumente',
        'akl' => 'Allg. Kranmkheitslehre',
        'bew' => 'Bewegungsapparat',
        'ngs' => 'Nervensystem Gehirn Sinne',
        'ges' => 'Fortpflanzung',
        'atm' => 'Atmung',
        'hau' => 'Haut- Hautanhangsgebilde',
        'nha' => 'Niere Harnwege',
    ];

    const FACH_KUERZEL = [
        'alg' => 'Allgemeinmedizin',
        'ano' => 'Anästhesiologie, Notfall- und Intensivmedizin',
        'ana' => 'Anatomie, Biologie',
        'aug' => 'Augenheilkunde',
        'bch' => 'Biochemie, Chemie, Molekularbiologie',
        'gen' => 'Humangenetik',
        'epi' => 'Epidemiologie, med. Biometrie',
        'chi' => 'Chirurgie',
        'der' => 'Dermatologie, Venerologie',
        'gyn' => 'Frauenheilkunde und Geburtshilfe',
        'hno' => 'Hals-Nasen-Ohrenheilkunde',
        'inn' => 'Innere Medizin',
        'kin' => 'Kinderheilkunde',
        'kch' => 'Klinische Chemie',
        'mps' => 'Med. Psychologie/Soziologie',
        'hyg' => 'Hygiene, Mikrobiologie',
        'neu' => 'Neurologie',
        'arb' => 'Arbeits- und Sozialmedizin, Gesundheitswesen',
        'ort' => 'Orthopädie',
        'pat' => 'Pathologie',
        'pha' => 'Pharmakologie, Toxikologie',
        'npm' => 'Naturheilverfahren, Physikalische Medizin',
        'phy' => 'Physiologie, Physik',
        'psy' => 'Psychiatrie, Psychosomatik',
        'rad' => 'Radiologie, Nuklearmedizin',
        'rec' => 'Rechtsmedizin',
        'uro' => 'Urologie',
    ];

    public function getData(): array {
        $data = [];

        foreach ($this->getCSVDataAsArray() as $dataLine) {

            $matrikelnummer = $dataLine["matnr"];
            foreach ($dataLine as $key => $ergebnis) {

                if ((strstr($key, "_") === FALSE) || !is_numeric($ergebnis)) {
                    continue;
                }

                $kuerzel = explode("_", $key)[0];

                if (array_key_exists($kuerzel, self::FACH_KUERZEL)) {
                    $clusterTyp = self::CLUSTER_FACH;
                    $clusterName = self::FACH_KUERZEL[$kuerzel];
                } elseif (array_key_exists($kuerzel, self::ORGANSYSTEM_KUERZEL)) {
                    $clusterTyp = self::CLUSTER_ORGANSYSTEM;
                    $clusterName = self::ORGANSYSTEM_KUERZEL[$kuerzel];
                } else {
                    continue;
                }

                $bewertungsTyp = explode("_", $key)[1];
                if (!in_array($bewertungsTyp, [CharitePTMPersistenzService::TYP_RICHTIG,
                                               CharitePTMPersistenzService::TYP_FALSCH,
                                               CharitePTMPersistenzService::TYP_WEISSNICHT])) {
                    continue;
                }
                $data[$matrikelnummer][$clusterTyp][$clusterName][$bewertungsTyp] = $ergebnis;
            }
        }

        return $data;
    }

}