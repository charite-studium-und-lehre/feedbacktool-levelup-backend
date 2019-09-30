<?php

namespace DatenImport\Domain;

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
        'ana'    => 'Anatomie',
        'bioch'  => 'Biochemie',
        'medSoz' => 'Medizinische Soziologie',
        'bio'    => 'Biologie',
        'medPsy' => 'medizinische Psychologie',
        'sozMed' => 'Sozialmedizin',

    ];
}
