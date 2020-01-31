<?php

namespace Demo\Infrastructure\Persistence;

use Symfony\Component\HttpFoundation\JsonResponse;

class MCFragenDemoData extends AbstractJsonDemoData
{
    protected array $jsonData = [
        "name"             => "MC-Test Semester 6 WiSe 2017 (Prüfungszeitraum 1)",
        "typ"              => "MC-Sem6",
        "format"           => "mc",
        "studiPruefungsId" => 5_620,
        "zeitsemester"     => "WiSe 2017",
        "periodeCode"      => 201_721,
        "periodeText"      => "WiSe 2017 (Prüfungszeitraum 1)",
        "fragen"           => [
            [
                "id"                  => "MC-Sem6-201721-952",
                "durchschnittRichtig" => 0.95,
                "text"                => "Fakefrage: Welches der Medikamente ist ein Kalziumkanalblocker vom Dihydropyridin-Typ?",
                "antworten"           => [
                    [
                        "text"        => "a) Sulfat.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Gluthation.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Serin.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Cystin.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F17",
                    "titel"  => "Pharmakologie, Toxikologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-5581",
                "durchschnittRichtig" => 0.74,
                "text"                => "Fakefrage: Was zählt nicht zu den modifizierten Duke Kriterien",
                "antworten"           => [
                    [
                        "text"        => "a) Herzinsuffizienz",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) positive Blutkulturen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) positives Echo",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) septische Lungeninfarkte",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F17",
                    "titel"  => "Pharmakologie, Toxikologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-5650",
                "durchschnittRichtig" => 0.99,
                "text"                => "Fakefrage: Welche Aussage zum Asthma Bronchiale bei Kindern im Schulalter trifft zu?",
                "antworten"           => [
                    [
                        "text"        => "a) es handelt sich meistens um nicht-allergisches Asthma.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Lungenfunktion in Ruhe meist normal.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) die Prävalenz beträgt 5-8 %.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) meist kommt es nicht zu einer Spontanremission.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F12",
                    "titel"  => "Kinderheilkunde",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-5661",
                "durchschnittRichtig" => 0.97,
                "text"                => "Fakefrage: Welche Tumore sind im hinteren Mediastinum am häufigsten?",
                "antworten"           => [
                    [
                        "text"        => "a) Thymom.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Schilddrüsentumor.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Neurinom.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-5670",
                "durchschnittRichtig" => 0.98,
                "text"                => "Fakefrage: Welches der Medikamente ist ein Kalziumkanalblocker vom Dihydropyridin-Typ?",
                "antworten"           => [
                    [
                        "text"        => "a) Hypocortisolismus",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Eisenmangel",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) Vitamin-B-Mangel",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Progesteronmangel",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-5705",
                "durchschnittRichtig" => 0.81,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Der Arzt, der den Tod feststellt und der Pathologe vor einer klinisch-pathologischen Sektion.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Der Arzt, der den Tod feststellt oder der Pathologe vor einer klinisch-pathologischen Sektion.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Der Arzt, der den Tod feststellt und der Pathologe nach einer klinisch-pathologischen Sektion.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Der Arzt, der den Tod feststellt oder der Pathologe nach einer klinisch-pathologischen Sektion.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F16",
                    "titel"  => "Pathologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-5713",
                "durchschnittRichtig" => 0.76,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Beta-Oxidation",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Glukoneogenese",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) Ketogenese",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Atmungskette",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Zitratzyklus",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S01",
                    "titel"  => "Physik, Physiologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-6129",
                "durchschnittRichtig" => 0.97,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Das Vorliegen von oben genannter sexueller Erlebnisfähigkeit hat an sich bereits Störungscharakter.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Pädophilie erreicht nur dann Störungscharakter, wenn die betreffenden Kinder das legale Einwilligungsalter von 14 Jahren unterschreiten.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Sadomasochismus oder Bondage kann klinisch nicht als Paraphilie mit Störungscharakter gewertet werden.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Erregbarkeit durch Fetische tritt immer als Paraphilie mit Störungscharakter auf.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Entscheidend für die diagnostische Zuordnung als Störung sind Leidensdruck, die Beeinträchtigung sozialer Funktionsbereiche oder aber Fremdgefährdung, also wenn das sexuelle Bedürfnis mit einer nicht einverstandenen Person ausgelebt wurde.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-6142",
                "durchschnittRichtig" => 0.89,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Cholinesterase",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Seryltransferase",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Monoaminoxidase",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) L-Aminosäureoxidase",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Lipoxygenase",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S02",
                    "titel"  => "Chemie, Biochemie, Molekurlarbiologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-6148",
                "durchschnittRichtig" => 0.93,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Eine Hypotrophie der Nebennierenrinde, weil sie die ACTH-Ausschüttung aus der Adenohypophyse stimulieren.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Eine Hypertrophie der Nebennierenrinde, weil sie die ACTH-Ausschüttung aus der Adenohypophyse stimulieren.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Eine Hypotrophie der Nebennierenrinde, weil sie die ACTH-Ausschüttung aus der Adenohypophyse hemmen.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Eine Hypertrophie der Nebennierenrinde, weil sie die ACTH-Ausschüttung aus der Adenohypophyse hemmen.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S02",
                    "titel"  => "Chemie, Biochemie, Molekurlarbiologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-6150",
                "durchschnittRichtig" => 0.7,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Gestagenmonopräparat, z.B. einer „Minipille“",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Kombinierte Hormonersatztherapie mit Estrogenen und Gestagenen (HRT)",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Kombinierte hormonelle Kontrazeption mit einem antiandrogen wirksamen Gestagen („Pille“)",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Einfache Estrogensubstitution ohne Gestagen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F07",
                    "titel"  => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-6283",
                "durchschnittRichtig" => 0.77,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Gesamtwasseranteil 90 %, IZW:EZW = 2:3",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Gesamtwasseranteil 80 %, IZW:EZW = 2:1",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Gesamtwasseranteil 75 %, IZW:EZW = 1:1",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Gesamtwasseranteil 60 %, IZW:EZW = 1:1",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Gesamtwasseranteil 55 %, IZW:EZW = 2:1",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S01",
                    "titel"  => "Physik, Physiologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-7459",
                "durchschnittRichtig" => 0.91,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Fibromuskuläre Kapsel",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Fibromuskuläres Stroma",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) Tubuloalveoläre Drüse",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Sperrarterie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S03",
                    "titel"  => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-7540",
                "durchschnittRichtig" => 0.93,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Galaktose",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Fukose",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Fruktose",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Mannose",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Maltose",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S02",
                    "titel"  => "Chemie, Biochemie, Molekurlarbiologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-7551",
                "durchschnittRichtig" => 0.5,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Die Follikelphase hat eine konstante Dauer von 12-14 Tagen.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Die Lutealphase hat eine konstante Dauer von 12-14 Tagen.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Die unbefruchtete Eizelle überlebt 5-7 Tage nach der Ovulation.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Spermien überleben 12-24 Stunden in der Gebärmutter.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) Kondome müssen nur am Tag des Eisprungs verwendet werden.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F07",
                    "titel"  => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-7764",
                "durchschnittRichtig" => 0.97,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Kreatinin",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) ADH",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Bilirubin",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Ammoniak",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) Aldosteron",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F11",
                    "titel"  => "Innere Medizin",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-8250",
                "durchschnittRichtig" => 0.84,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Fachinformation",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) AkdÄ (Arzneimittelkommission der deutschen Ärzteschaft)",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Rote Liste",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) www.dosing.de",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F17",
                    "titel"  => "Pharmakologie, Toxikologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-9337",
                "durchschnittRichtig" => 0.93,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Sie mündet in die V. lumbalis ein.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Sie hat einen gewundenen Verlauf.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Sie überkreuzt den Ureter.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Die rechte V. ovarica mündet in die V. renalis.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Sie hat eine Verbindung zur V. umbilicalis.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S03",
                    "titel"  => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-9704",
                "durchschnittRichtig" => 0.82,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) PRL und GH",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Alpha-Untereinheit von GH und TSH",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Alpha-Untereinheit von TSH und LH",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Beta-Untereinheit von LH und FSH",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Beta-Untereinheit von hCG und TSH",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S02",
                    "titel"  => "Chemie, Biochemie, Molekurlarbiologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-9904",
                "durchschnittRichtig" => 0.71,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Für das Vorliegen einer anaphylaktischen Medikamentenreaktion",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Für das Vorliegen eines hämorrhagischen Schocks",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) Für das Vorliegen einer Anästhetika-induzierten Tachykardie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Für das Vorliegen einer zentral bedingten Störung des Kreislaufzentrums infolge eines Schädel-Hirn-Traumas",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F02",
                    "titel"  => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-9958",
                "durchschnittRichtig" => 0.89,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Ängste",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Aggressives Verhalten",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Geringes Selbstwertgefühl",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Auffälliges Sexualverhalten",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Es gibt keine missbrauchsspezifische Symptomatik.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-10245",
                "durchschnittRichtig" => 0.98,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Metabolische Alkalose",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Hypotonie, Tachykardie",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) Harndrang, Polyurie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Alveoläre Hypoventilation",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F02",
                    "titel"  => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-10677",
                "durchschnittRichtig" => 0.97,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Gegen die Durchführung der Schamlippenverkleinerung spricht nichts, zumal es kaum Risiken gibt.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Es ist anzunehmen, dass die sexuelle und partnerschaftliche Beziehungszufriedenheit der jungen Frau hoch ist. Fragen hierzu erübrigen sich.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Es ist anzunehmen, dass die sexuelle und partnerschaftliche Beziehungszufriedenheit gering ist. Fragen hierzu verbieten sich deshalb.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Es ist denkbar, dass bei der jungen Frau eine Selbstwertproblematik vorliegt, die sich auf das körperliche und sexuelle Erleben ausgedehnt hat.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) Ärztliche Hinweise auf mögliche Komplikationen schönheitschirurgischer Eingriffe erweisen sich meist als wirksam und führen zu einer Distanzierung von derartigen Wünschen.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-10733",
                "durchschnittRichtig" => 0.77,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Die TRH-PRL-Achse",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Die Oxytocin-Achse",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Die GH-IGF-Achse",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Die Schilddrüsenhormonachse",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Keine dieser endokrinen Achsen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F11",
                    "titel"  => "Innere Medizin",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-10921",
                "durchschnittRichtig" => 0.54,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) rektosigmoidaler Übergang",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) oberes Rektumdrittel",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) mittleres Rektumdrittel",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) unteres Rektumdrittel",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) alle oben angeführten Regionen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F07",
                    "titel"  => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-10982",
                "durchschnittRichtig" => 0.85,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Symptomatische Therapie einer Hypothermie: Verminderung des Wärmeverlustes durch periphere Vasokonstriktion",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Symptomatische Therapie einer Hypotension: Anhebung des peripheren Gefäßwiderstandes zur Sicherstellung eines ausreichenden arteriellen Blutdrucks",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Kausale Therapie einer Hypotension: Verminderung des Blutverlustes durch lokale Vasokonstriktion",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Symptomatische Therapie eines Schocks: Steigerung der kardialen Inotropie durch katecholamin-induzierte Tachykardie (Bedarfstachykardie)",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) Kausale Therapie eines relativen Mangels endogener Katecholamine infolge einer Nebennierenmarksinsuffizienz auf dem Boden einer retroperitonealen Blutung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F02",
                    "titel"  => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-11035",
                "durchschnittRichtig" => 0.95,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Volumengabe zum Ausgleich von Blut- und Flüssigkeitsverlusten",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Sicherstellung eines ausreichenden arteriellen Blutdrucks zur Gewebeperfusion",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Reposition von Frakturen am Unfallort",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Analgetische Therapie am Unfallort",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Einholung einer Behandlungseinwilligung (ggf. durch einen gesetzlichen Betreuer), wenn der Patientenwille nicht offensichtlich erkennbar ist",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F02",
                    "titel"  => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-12052",
                "durchschnittRichtig" => 0.98,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Bradykardie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Blasse Haut",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Atemnot durch Bronchospasmus",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Hypoxämie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Pulmonale Hypotension",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F17",
                    "titel"  => "Pharmakologie, Toxikologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-12378",
                "durchschnittRichtig" => 0.83,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Anteversio und Retroflexio",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Retroversio und Anteflexio",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Retroversio und Retroflexio",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Anteversio und Anteflexio",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S03",
                    "titel"  => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-13017",
                "durchschnittRichtig" => 0.9,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) erhöhte Konzentrationen von TNFa, IL6, Katecholaminen, Cortisol",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) erhöhte Konzentrationen von Insulin, T3, IGF",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) erniedrigte Konzentrationen von Lipidmobilisierendem Faktor (LMF) und Proteolyse-induzierendem Faktor (PIF)",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F11",
                    "titel"  => "Innere Medizin",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-13137",
                "durchschnittRichtig" => 0.91,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Über die Ausschüttung von Oxytocin aus dem Hypothalamus, welches an Oxytocin-Rezeptoren in dopaminergen Strukturen des Gehirns bindet.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Über die Ausschüttung von Oxytocin aus dem Hypothalamus, welches an Oxytocin-Rezeptoren in  serotonergen Strukturen des Gehirns bindet.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Über die Ausschüttung von Oxytocin aus dem Hippocampus, welches an Oxytocin-Rezeptoren in  dopaminergen Strukturen des Gehirns bindet.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Über die Ausschüttung von Oxytocin aus dem Hippocampus, welches an Oxytocin-Rezeptoren in serotonergen Strukturen des Gehirns bindet.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S04",
                    "titel"  => "Psychologie, Soziologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-13252",
                "durchschnittRichtig" => 0.5,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Hydrocortison und Fludrocortison",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Hydrocortison und Dexamethason",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Monotherapie mit Hydrocortison",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Monotherapie mit Fludrocortison",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F11",
                    "titel"  => "Innere Medizin",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-13930",
                "durchschnittRichtig" => 0.73,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Datenerhebung – Problembeschreibung – Liste von Differentialdiagnosen",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Blickdiagnose – alternative „must not miss“ - Diagnosen – diagnostische Aufarbeitung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Leitsymptom festlegen  – Vorgeschichte erfassen – Diagnoseliste aus elektronischer Datenbank (z.B. up-to-date®) erstellen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Vordiagnose (z.B. des Zuweisers) erfassen – diagnostische Überprüfung – ggf. alternative Verdachtsdiagnosen formulieren",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F11",
                    "titel"  => "Innere Medizin",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-14219",
                "durchschnittRichtig" => 0.41,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) inhomogenes, alveoläres Verdichtungsmuster",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) inhomogenes, interstitielles Verdichtungsmuster",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) homogene, scharf begrenzte Verdichtung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) homogene, unscharf begrenzte Verdichtung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "Q11",
                    "titel"  => "Bildgebende Verfahren, Strahlenbehandlung",
                    "gruppe" => "Querschnittsfächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-14240",
                "durchschnittRichtig" => 0.61,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Röntgen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Ultraschall",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) native Computertomographie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Mehrphasen-Computertomographie",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "Q11",
                    "titel"  => "Bildgebende Verfahren, Strahlenbehandlung",
                    "gruppe" => "Querschnittsfächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-15046",
                "durchschnittRichtig" => 0.27,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Cortisol",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Dehydroepiandrosteronsulfat (DHEAS)",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Testosteron",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) 17alpha-Hydroxyprogesteron",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Östron",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F12",
                    "titel"  => "Kinderheilkunde",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-15112",
                "durchschnittRichtig" => 0.77,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) FSH niedrig und Estradiol niedrig",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) FSH hoch und Estradiol hoch",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) FSH hoch und Estradiol niedrig",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) LH niedrig und Estradiol hoch",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F07",
                    "titel"  => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-15261",
                "durchschnittRichtig" => 0.57,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Hymenalatresie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) konstitutionelle späte Pubertät",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) angeborene Hypoplasie von Vagina und Uterus",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Androgen-Insistivitäts-Syndrom",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Turner-Syndrom",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F07",
                    "titel"  => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-16051",
                "durchschnittRichtig" => 0.78,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Entzündung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Ischämie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Hohlorganperforation",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Hohlorgandistension",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Blutung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F11",
                    "titel"  => "Innere Medizin",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-16313",
                "durchschnittRichtig" => 0.76,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Jährliche Check-ups beim Hausarzt/bei der Hausärztin",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Abschied von Perfektionismus",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) Selbstvermessungs-App",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Sauerstoff-Therapie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-17023",
                "durchschnittRichtig" => 0.95,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) anaphylaktische Reaktion auf Plasmaproteine im Erythrozytenkonzentrat",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) transfusionsassoziierte Volumenüberladung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) hämolytische Transfusionsreaktion (AB0-Verwechslung)",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) febrile nicht-hämolytische Transfusionsreaktion",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Volumenmangelschock aufgrund eines akuten Blutverlustes",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F13",
                    "titel"  => "Klinische Chemie, Laboratoriumsdiagnostik",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-17188",
                "durchschnittRichtig" => 0.7,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) < 10 %",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) ca. 20 %",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) ca. 40 %",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) ca. 60 %",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) > 70 %",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S01",
                    "titel"  => "Physik, Physiologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-17842",
                "durchschnittRichtig" => 0.72,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Tetraparese",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) ausgefallene Bauchhautreflexe in allen Etagen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) schlaffer Muskeltonus",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) vertikale Augenbewegungen bei Ansprache",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) ausgefallener vestibulo-okulärer Reflex",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F14",
                    "titel"  => "Neurologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-18100",
                "durchschnittRichtig" => 0.86,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) MRT des Abdomens",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Gastrografinschluck",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Röntgen-Abdomenübersichtsaufnahme",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Digitale Subtraktionsangiographie der Mesenterialarterien",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Nierenszintigraphie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "Q11",
                    "titel"  => "Bildgebende Verfahren, Strahlenbehandlung",
                    "gruppe" => "Querschnittsfächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-18311",
                "durchschnittRichtig" => 0.69,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) biogene Amine",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Glykoproteine",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Polypeptide",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Steroide",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S03",
                    "titel"  => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-18317",
                "durchschnittRichtig" => 0.95,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Es kann über die Fortführung oder Beendigung der Therapie mit Dexamethason entschieden werden.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Es kann bei einem weiblichen Fötus eine Substitutionstherapie mit Östrogenen begonnen werden.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Es kann bei einem männlichen Fötus eine Substitutionstherapie mit Testosteron begonnen werden.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Es kann bei einem männlichen Neugeborenen unmittelbar nach der Geburt eine sofortige operative Korrektur der Genitalien in einem dafür spezialisierten Zentrum organisiert werden.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F12",
                    "titel"  => "Kinderheilkunde",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-18344",
                "durchschnittRichtig" => 0.86,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) CT von Abdomen und Becken",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Ultraschall von Harnblase und Nieren",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Urinzytologie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Miktionszysturethrogramm",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Harnstrahlmessung (Uroflow)",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F21",
                    "titel"  => "Urologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-19526",
                "durchschnittRichtig" => 0.94,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Zentral sind Wohl und Schutz des einzelnen Menschen.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Zentral sind optimale Rahmenbedingungen für Forschung und Lehre.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Zentral sind Wohlergehen und gedeihliches Miteinander der Gemeinschaft.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Zentral sind Forschungsfreiheit und wissenschaftlicher Fortschritt.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20422",
                "durchschnittRichtig" => 0.43,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Der onkotische Druck des Plasmas nimmt ab und steigert dadurch die Flüssigkeitsaufnahme aus dem interstitiellen Raum in die Kapillare.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Der hydrostatische Druck des Plasmas in der Kapillare nimmt ab und steigert dadurch die Flüssigkeitsaufnahme aus dem interstitiellen Raum in die Kapillare.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) Die präkapillären Arteriolen dilatieren, um die Peripherie mit hinreichend Sauerstoff zu versorgen.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Die postkapillären Venolen konstringieren, um die Flüssigkeitsaufnahme aus dem interstitiellen Raum in die Kapillare zu erhöhen.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Die arteriovenösen Shunts der Hautgefäße dilatieren, um das Blutvolumen zu zentralisieren.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S01",
                    "titel"  => "Physik, Physiologie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20429",
                "durchschnittRichtig" => 0.95,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Monogamie, Selbstbefriedigung, sexuelle Fantasie und sexuelles Verhalten",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Akzeptanz, Nähe, Wärme, Geborgenheit",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "c) Wohnung, finanzielle Sicherheit, Karrieremöglichkeit, Nahrung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Affekt, Mnestik, örtliche und zeitliche Orientierung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20550",
                "durchschnittRichtig" => 0.94,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) dominanter Tertiärfollikel",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Primärfollikel",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Sekundärfollikel",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Corpus luteum",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) Corpus albicans",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S03",
                    "titel"  => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20551",
                "durchschnittRichtig" => 0.79,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Labia majora",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) laterale Beckenwand",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Os pubis",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Os sacrum",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Harnblasenwandung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "S03",
                    "titel"  => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M22",
                    "titel" => "Modul 22",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20641",
                "durchschnittRichtig" => 0.92,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Medikamentennebenwirkungen",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "b) Chronic Fatigue Syndrom",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Fatigue als Folge einer Herzinsuffizienz",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Schlafbezogene Atemstörung",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "A",
                    "titel"  => "Anderes",
                    "gruppe" => "Andere",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20682",
                "durchschnittRichtig" => 0.87,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Gabe von 1 mg Adrenalin intravenös",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Gabe von 300 mg Amiodaron intravenös",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Sofortige Defibrillation und anschließende erneute Rhythmusanalyse mit Beendigung der Herzdruckmassage",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Sofortige Defibrillation, gefolgt von einer Herzdruckmassage mittels 30 Thoraxkompressionen und 2 Beatmungen mittels Ambu-Beutel und Maske über 5 Zyklen und hiernach erneute Rhythmusanalyse",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F02",
                    "titel"  => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20686",
                "durchschnittRichtig" => 0.15,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Erhalten eines hohen Niveaus an Inhibitoren der Blutgerinnung.",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Heparingabe auch bei blutenden Patienten.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Substitution von Thrombozyten, wenn die Thrombozytenzahl < 100.000/µl ist.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "d) Gabe von Antithrombin, wenn Antithrombin-III-Spiegel < 70% der Norm.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "e) Gabe von Prothrombinkonzentrat, wenn Antithrombin-III-Spiegel > 70% der Norm.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F02",
                    "titel"  => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20688",
                "durchschnittRichtig" => 0.68,
                "text"                => "XXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Häufige Durchführung von Routinelaborentnahmen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Maximierung der Sauerstoffversorgung mittels Dobutamin",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Aufrechterhaltung einer Normovolämie",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Intraoperative autologe Blutrückgewinnung (Cell-Saver)",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) Prophylaktische Gabe von Tranexamsäure bei jeder Operation",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F02",
                    "titel"  => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20741",
                "durchschnittRichtig" => 0.22,
                "text"                => "XXXXXXXX?",
                "antworten"           => [
                    [
                        "text"        => "a) Hohes Risiko - Fibrinolyse",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Intermediär hohes Risiko – Antikoagulation, Fibrinolyse erwägen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Intermediär niedriges Risiko - Antikoagulation",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Niedriges Risiko – Antikoagulation, ambulante Behandlung möglich",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) Ohne Echokardiographie ist eine Einteilung des Risikos und Ableitung der Therapie hier nicht möglich.",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F02",
                    "titel"  => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
            [
                "id"                  => "MC-Sem6-201721-20955",
                "durchschnittRichtig" => 0.72,
                "text"                => "XXXXXXXX ?",
                "antworten"           => [
                    [
                        "text"        => "a) Verzehr von Erdnüssen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "b) Expiratorischer Stridor",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "c) Giemen und Brummen",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                    [
                        "text"        => "d) Plötzlicher Husten",
                        "richtig"     => TRUE,
                        "ausgewaehlt" => TRUE,
                    ],
                    [
                        "text"        => "e) Beidseits abgeschwächtes Atemgeräusch",
                        "richtig"     => FALSE,
                        "ausgewaehlt" => FALSE,
                    ],
                ],
                "fach"                => [
                    "code"   => "F12",
                    "titel"  => "Kinderheilkunde",
                    "gruppe" => "Klinische Fächer",
                ],
                "modul"               => [
                    "code"  => "M21",
                    "titel" => "Modul 21",
                ],
            ],
        ],
    ];

    public function getController(string $pathInfo): callable {
        preg_match("/\/[0-9]+\//", $pathInfo, $matches);
        if ($matches[0]) {
            $studiPruefungsId = str_replace("/", "", $matches[0]);
            $this->jsonData["studiPruefungsId"] = $studiPruefungsId;
        }

        return fn() => new JsonResponse($this->jsonData);
    }

    public function isResponsibleFor(string $pathInfo): bool {
        $pathInfo = preg_replace("/\/[0-9]+/", "", $pathInfo);

        return $pathInfo == "/api/pruefungen/fragen";
    }

}