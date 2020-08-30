<?php

namespace Pruefung\Domain;

class FachCodeKonstanten
{
    const FACH_CODES = [
        'F01' => 'Allgemeinmedizin',
        'F02' => 'Anästhesiologie',
        'F03' => 'Arbeitsmedizin, Sozialmedizin',
        'F04' => 'Augenheilkunde',
        'F05' => 'Chirurgie',
        'F06' => 'Dermatologie, Venerologie',
        'F07' => 'Frauenheilkunde, Geburtshilfe',
        'F08' => 'Hals-Nasen-Ohrenheilkunde',
        'F09' => 'Humangenetik',
        'F10' => 'Hygiene, Mikrobiologie, Virologie',
        'F11' => 'Innere Medizin',
        'F12' => 'Kinderheilkunde',
        'F13' => 'Klinische Chemie, Laboratoriumsdiagnostik',
        'F14' => 'Neurologie',
        'F15' => 'Orthopädie',
        'F16' => 'Pathologie',
        'F17' => 'Pharmakologie, Toxikologie',
        'F18' => 'Psychiatrie und Psychotherapie, Psychosomatik', // F18 + F19

        'F20' => 'Rechtsmedizin',
        'F21' => 'Urologie',

        'S01' => 'Physik, Physiologie',
        'S02' => 'Chemie, Biochemie, Molekurlarbiologie',
        'S03' => 'Biologie, Anatomie',
        'S04' => 'Psychologie, Soziologie',

        'Q01' => 'Epidemiologie, medizinische Biometrie und medizinische Informatik',
        'Q11' => 'Bildgebende Verfahren, Strahlenbehandlung',
        'Q12' => 'Rehabilitation, Physikalische Medizin, Naturheilverfahren',
        'FÜ'  => 'Fachübergreifend',
        'A'   => 'Anderes',
    ];

    const MC_FACH_ZUSAMMENFASSUNG = [
        'F19' => 'A',
        'Q02' => 'A',
        'Q03' => 'F03',
        'Q04' => 'A',
        'Q06' => 'A',
        'Q07' => 'F11',
        'Q08' => 'F02',
        'Q09' => 'F17',
        'Q10' => 'F03',
        'Q13' => 'A',
        'Q14' => 'A',
        'Z01' => 'A',
        'Z02' => 'A',
        'Z03' => 'Q11',
        'Z04' => 'A',
        'T01' => 'A',
        'D1'  => 'S03', // GeWi Biologie, ist aus irgendwelchen Gründen zugeordnetz. TODO:  Daten fixen.
    ];

    public const PTM_FACH_KUERZEL = [
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

    public const PTM_CODE_ZU_FACH_CODE = [
        'alg' => 'F01',
        'ano' => 'F02',
        'arb' => 'F03',
        'aug' => 'F04',
        'chi' => 'F05',
        'der' => 'F06',
        'gyn' => 'F07',
        'hno' => 'F08',
        'gen' => 'F09',
        'hyg' => 'F10',
        'inn' => 'F11',
        'kin' => 'F12',
        'kch' => 'F13',
        'neu' => 'F14',
        'ort' => 'F15',
        'pat' => 'F16',
        'pha' => 'F17',
        'psy' => 'F18',
        'rec' => 'F20',
        'uro' => 'F21',
        'epi' => 'Q01',
        'rad' => 'Q11',
        'npm' => 'Q12',
        'phy' => 'S01',
        'bch' => 'S02',
        'ana' => 'S03',
        'mps' => 'S04',
    ];

    public const STATION_VK_KURZEL = [
        'Anatomie'                 => 'ana',
        'Biochemie'                => 'bioch',
        'Medizinische Soziologie'  => 'medSoz',
        'Biologie'                 => 'bio',
        'medizinische Psychologie' => 'medPsy',
        'Sozialmedizin'            => 'sozMed',

        'Physiologie' => 'phys',

        'Med.Psych/Anatomie/Biologie/Med.Soz./Sozialmedizin' => 'div',
        'NA'                                                 => 'div',

        '1291_Bio'       => 'bioch',
        '1292_Bio'       => 'bio',
        '1292_Med_Psych' => 'medPsy',
        '1292_Med_Soz'   => 'medSoz',
        '1292_Anatomie'  => 'ana',
        '1292_Sozialmed' => 'sozMed',
    ];

    public const STATION_VK_TITEL = [
        'ana'    => 'Anatomie',
        'bioch'  => 'Biochemie',
        'medSoz' => 'Medizinische Soziologie',
        'bio'    => 'Biologie',
        'medPsy' => 'Medizinische Psychologie',
        'sozMed' => 'Sozialmedizin',
        'phys'   => 'Physiologie',
        'div'    => 'Med.Psych/Anatomie/Biologie/Med.Soz./Sozialmedizin',
    ];

    public const STATIONS_BEZEICHNUNGEN = [
        # OSCE 2. FS (Stationsprüfung Teil 1)
        'S1#N1' => 'Notfallstation',
        'S1#N2' => 'Notfallstation',
        'S1#N3' => 'Notfallstation',
        '51#N3' => 'Notfallstation', # sic!
        'S1#N4' => 'Notfallstation',
        'S1#U1' => 'Untersuchungskursstation ',
        'S1#U2' => 'Untersuchungskursstation ',
        'S1#U3' => 'Untersuchungskursstation ',
        'S1#U4' => 'Untersuchungskursstation ',

        # OSCE 4. FS (Stationsprüfung Teil 3)
        '00#03' => 'KIT Gesprächstechnik ',
        '09#01' => 'Haut M09',
        '10#01' => 'Bewegung M10',
        '10#02' => 'Bewegung M10',
        '10#03' => 'Bewegung M10',
        '11#01' => 'Herz Kreislauf M11',
        '11#02' => 'Herz Kreislauf M11',
        '12#01' => 'Ern./Verd./Stoffw. M12 ',
        '12#02' => 'Ern./Verd./Stoffw. M12 ',
        '13#01' => 'Atmung M13',
        '13#02' => 'Atmung M13',
        '14#01' => 'Niere/Elektrolyte M14',
        '14#02' => 'Niere/Elektrolyte M14',
        '14#04' => 'Niere/Elektrolyte M14',
        '15#01' => 'Nervensystem M15',
        '15#02' => 'Nervensystem M15',
        '15#03' => 'Nervensystem M15',
        '16#01' => 'Sinnesorgane M16',
        '16#02' => 'Sinnesorgane M16',
        '16#03' => 'Sinnesorgane M16',
        '16#04' => 'Sinnesorgane M16',

        # OSCE 9. FS
        '00#04' => 'KIT Gesprächstechnik ',
        '27#01' => 'Erkrankungen der Extremitäten M27',
        '27#02' => 'Erkrankungen der Extremitäten M27',
        '27#03' => 'Erkrankungen der Extremitäten M27',
        '30#01' => 'Neurologische Erkrankungen M30',
        '31#02' => 'Psychiatrische Erkrankungen M31',
        '31#05' => 'Psychiatrische Erkrankungen M31',
        '33#01' => 'Schwangerschaft/Geburt M33',
        '34#01' => 'Kindesalter/ Adoleszenz M34',
        '34#02' => 'Kindesalter/ Adoleszenz M34',
        '34#03' => 'Kindesalter/ Adoleszenz M34',
        '35#01' => 'Geschlechtsspezifische Erkrankungen M35',
        '36#01' => 'Alter/Tod/Sterben M36',
        '36#02' => 'Alter/Tod/Sterben M36',
    ];

    public const STATION_WISSENS_TYP_FAKTEN = "fakten";
    public const STATION_WISSENS_TYP_ZUSAMMENHANG = "zusamm";
    public const STATION_WISSENS_TYPEN = [
        self::STATION_WISSENS_TYP_FAKTEN       => "Faktenwissen",
        self::STATION_WISSENS_TYP_ZUSAMMENHANG => "Zusammenhangswissen",
    ];

    public static function getFachGruppeByFach(string $fachCode): string {
        $fachChar = substr($fachCode, 0, 1);

        switch ($fachChar) {
            case "F":
                $gruppe = "Klinische Fächer";
                break;
            case "Q":
                $gruppe = "Querschnittsfächer";
                break;
            case "S":
                $gruppe = "Vorklinische Fächer";
                break;
            default:
                $gruppe = "Andere";
        }

        return $gruppe;
    }
}
