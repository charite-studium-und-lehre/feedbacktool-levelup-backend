<?php

namespace Demo\Infrastructure\Persistence;

class MCFragenDemoData extends AbstractJsonDemoData
{
    protected $jsonData = [
        "name" => "MC-Test Semester 6 WiSe 2017 (Prüfungszeitraum 1)",
        "typ" => "MC-Sem6",
        "format" => "mc",
        "studiPruefungsId" => 5620,
        "zeitsemester" => "WiSe 2017",
        "periodeCode" => 201721,
        "periodeText" => "WiSe 2017 (Prüfungszeitraum 1)",
        "fragen" => [
            [
                "id" => "MC-Sem6-201721-952",
                "durchschnittRichtig" => 0.95,
                "text" => "Die Körperlänge eines 5-jährigen Jungen entspricht der 75. Perzentile. Was bedeutet das?",
                "antworten" => [
                    [
                        "text" => "a) Mit einer Wahrscheinlichkeit von etwa 75 % ist die Größe normal.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Mit einer Wahrscheinlichkeit von etwa 25 % ist die Größe normal.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Etwa 75 % der gleichaltrigen Jungen sind kleiner.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Etwa 25 % der der gleichaltrigen Jungen sind kleiner.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F12",
                    "titel" => "Kinderheilkunde",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-5581",
                "durchschnittRichtig" => 0.74,
                "text" => "Was umfasst das pharmakologische Prinzip der selektiven nukleären Hormonrezeptormodulation?",
                "antworten" => [
                    [
                        "text" => "a) die ligandenabhängige Aktivierung von Secondmessenger-Molekülen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) die ligandenunabhängige Degradation von Rezeptorkomplexen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) die ligandenabhängige Rekrutierung von Histonen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) die ligandenabhängige Rekrutierung von nuklearen Ko-Faktoren zum Rezeptor",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "F17",
                    "titel" => "Pharmakologie, Toxikologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-5650",
                "durchschnittRichtig" => 0.99,
                "text" => "Welcher der folgenden Einflussfaktoren ist bei der Planung der Durchführung der Messung der Serumkonzentration von Cortisol zu beachten?",
                "antworten" => [
                    [
                        "text" => "a) Einhalten eines nikotinfreien Intervalls vor der Blutentnahme bei Rauchern.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Beachtung des zirkadianen Rhythmus bei der Festlegung des Zeitpunkts zur Blutentnahme.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Ermittlung des Körpergewichts zur Bestimmung der Cortisol-Ratio.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Einhaltung einer kohlenhydratreichen Diät über 2 Tage vor Blutentnahme.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F13",
                    "titel" => "Klinische Chemie, Laboratoriumsdiagnostik",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-5661",
                "durchschnittRichtig" => 0.97,
                "text" => "Welche Ansätze zur Vermeidung von Gewalt in der Helfer-Patient-Beziehung haben nachweislich Effekte?",
                "antworten" => [
                    [
                        "text" => "a) Gut ausgebildetes Personal.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Farbgestaltung der Stationen.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Später Beginn der Arbeitszeit.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S04",
                    "titel" => "Psychologie, Soziologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-5670",
                "durchschnittRichtig" => 0.98,
                "text" => "Was ist häufig Ursache einer chronischen Erschöpfung?",
                "antworten" => [
                    [
                        "text" => "a) Hypocortisolismus",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Eisenmangel",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Vitamin-B-Mangel",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Progesteronmangel",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "A",
                    "titel" => "Anderes",
                    "gruppe" => "Andere"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-5705",
                "durchschnittRichtig" => 0.81,
                "text" => "Wer führt die äußere Leichenschau durch?",
                "antworten" => [
                    [
                        "text" => "a) Der Arzt, der den Tod feststellt und der Pathologe vor einer klinisch-pathologischen Sektion.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Der Arzt, der den Tod feststellt oder der Pathologe vor einer klinisch-pathologischen Sektion.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Der Arzt, der den Tod feststellt und der Pathologe nach einer klinisch-pathologischen Sektion.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Der Arzt, der den Tod feststellt oder der Pathologe nach einer klinisch-pathologischen Sektion.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F16",
                    "titel" => "Pathologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-5713",
                "durchschnittRichtig" => 0.76,
                "text" => "Welcher der aufgeführten Stoffwechselprozesse ist die dominante Quelle von Sauerstoffradikalen beim Reperfusionssyndrom?",
                "antworten" => [
                    [
                        "text" => "a) Beta-Oxidation",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Glukoneogenese",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Ketogenese",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Atmungskette",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Zitratzyklus",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S01",
                    "titel" => "Physik, Physiologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-6129",
                "durchschnittRichtig" => 0.97,
                "text" => "Paraphilien sind unter anderem gekennzeichnet durch wiederkehrende, intensive sexuelle Erregung durch nicht-menschliche Objekte, körperliches Leiden oder die Demütigung von sich selbst oder seines Partners, von Kindern oder nicht einwilligenden oder nicht einwilligungsfähigen Personen. Was trifft für den Störungscharakter von Paraphilien zu?",
                "antworten" => [
                    [
                        "text" => "a) Das Vorliegen von oben genannter sexueller Erlebnisfähigkeit hat an sich bereits Störungscharakter.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Pädophilie erreicht nur dann Störungscharakter, wenn die betreffenden Kinder das legale Einwilligungsalter von 14 Jahren unterschreiten.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Sadomasochismus oder Bondage kann klinisch nicht als Paraphilie mit Störungscharakter gewertet werden.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Erregbarkeit durch Fetische tritt immer als Paraphilie mit Störungscharakter auf.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Entscheidend für die diagnostische Zuordnung als Störung sind Leidensdruck, die Beeinträchtigung sozialer Funktionsbereiche oder aber Fremdgefährdung, also wenn das sexuelle Bedürfnis mit einer nicht einverstandenen Person ausgelebt wurde.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "A",
                    "titel" => "Anderes",
                    "gruppe" => "Andere"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-6142",
                "durchschnittRichtig" => 0.89,
                "text" => "Welches Enzym ist wesentlich am Abbau von Serotonin beteiligt?",
                "antworten" => [
                    [
                        "text" => "a) Cholinesterase",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Seryltransferase",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Monoaminoxidase",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) L-Aminosäureoxidase",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Lipoxygenase",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S02",
                    "titel" => "Chemie, Biochemie, Molekurlarbiologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-6148",
                "durchschnittRichtig" => 0.93,
                "text" => "Was bewirkt die Gabe von Corticosteroiden?",
                "antworten" => [
                    [
                        "text" => "a) Eine Hypotrophie der Nebennierenrinde, weil sie die ACTH-Ausschüttung aus der Adenohypophyse stimulieren.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Eine Hypertrophie der Nebennierenrinde, weil sie die ACTH-Ausschüttung aus der Adenohypophyse stimulieren.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Eine Hypotrophie der Nebennierenrinde, weil sie die ACTH-Ausschüttung aus der Adenohypophyse hemmen.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Eine Hypertrophie der Nebennierenrinde, weil sie die ACTH-Ausschüttung aus der Adenohypophyse hemmen.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S02",
                    "titel" => "Chemie, Biochemie, Molekurlarbiologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-6150",
                "durchschnittRichtig" => 0.7,
                "text" => "Eine 25-jährige Patientin kommt in die Hochschulambulanz, weil sie seit fünf Monaten keine Blutungen mehr hatte. Ein Schwangerschaftstest war negativ. Außerdem stört sie seit langem eine Akne und nun auch ein progredienter Haarwuchs im Bereich der Oberlippe. Der Testosteronwert ist leicht erhöht (0,49 ng/ml), ansonsten liegen alle Hormonwerte (FSH, LH, Prolaktin, TSH, Estradiol, Progesteron, DHEAS) im Normbereich. Womit sollte die Patientin am besten behandelt werden?",
                "antworten" => [
                    [
                        "text" => "a) Gestagenmonopräparat, z.B. einer „Minipille“",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Kombinierte Hormonersatztherapie mit Estrogenen und Gestagenen (HRT)",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Kombinierte hormonelle Kontrazeption mit einem antiandrogen wirksamen Gestagen („Pille“)",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Einfache Estrogensubstitution ohne Gestagen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F07",
                    "titel" => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-6283",
                "durchschnittRichtig" => 0.77,
                "text" => "Welche der genannten Hydratationszustände ist bei Kleinkindern physiologisch?",
                "antworten" => [
                    [
                        "text" => "a) Gesamtwasseranteil 90 %, IZW:EZW = 2:3",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Gesamtwasseranteil 80 %, IZW:EZW = 2:1",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Gesamtwasseranteil 75 %, IZW:EZW = 1:1",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Gesamtwasseranteil 60 %, IZW:EZW = 1:1",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Gesamtwasseranteil 55 %, IZW:EZW = 2:1",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "S01",
                    "titel" => "Physik, Physiologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-7459",
                "durchschnittRichtig" => 0.91,
                "text" => "Diese Frage bezieht sich auf die Abbildung 7459 in der Bildbeilage:---
Sie sehen einen Anschnitt der Prostata (H.E.-Färbung). Welche Struktur wurde mit der Klammer 2 markiert?",
                "antworten" => [
                    [
                        "text" => "a) Fibromuskuläre Kapsel",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Fibromuskuläres Stroma",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Tubuloalveoläre Drüse",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Sperrarterie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S03",
                    "titel" => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-7540",
                "durchschnittRichtig" => 0.93,
                "text" => "Welche der aufgeführten Substanzen ist das wichtigste energieliefernde Substrat für reife Spermien?",
                "antworten" => [
                    [
                        "text" => "a) Galaktose",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Fukose",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Fruktose",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Mannose",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Maltose",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S02",
                    "titel" => "Chemie, Biochemie, Molekurlarbiologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-7551",
                "durchschnittRichtig" => 0.5,
                "text" => "Eine Patientin kommt zur kontrazeptiven Beratung in Ihre Sprechstunde. Sie möchte nur mit Kondomen verhüten und wissen, wann ihr Eisprung ist und wie lange sie vor und nach dem Eisprung schwanger werden kann. Ihr Zyklus hat eine Dauer von 26-30 Tagen. Welche Information ist für die Patientin in Bezug auf die Verhütung mit Kondomen von Bedeutung?",
                "antworten" => [
                    [
                        "text" => "a) Die Follikelphase hat eine konstante Dauer von 12-14 Tagen.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Die Lutealphase hat eine konstante Dauer von 12-14 Tagen.",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Die unbefruchtete Eizelle überlebt 5-7 Tage nach der Ovulation.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Spermien überleben 12-24 Stunden in der Gebärmutter.",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) Kondome müssen nur am Tag des Eisprungs verwendet werden.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F07",
                    "titel" => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-7764",
                "durchschnittRichtig" => 0.97,
                "text" => "Welcher Mediator ist an der Entstehung der hepatischen Enzephalopathie beteiligt?",
                "antworten" => [
                    [
                        "text" => "a) Kreatinin",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) ADH",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Bilirubin",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Ammoniak",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) Aldosteron",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F11",
                    "titel" => "Innere Medizin",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-8250",
                "durchschnittRichtig" => 0.84,
                "text" => "Sie möchten Amoxicillin 750 mg (1-0-1) zur Therapie einer bakteriellen Otitis media für 7 Tage verschreiben. Sie möchten die Preisangaben der verschiedenen Präparate für eine N2-Packung vergleichen. Wo finden Sie die gewünschten Angaben?",
                "antworten" => [
                    [
                        "text" => "a) Fachinformation",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) AkdÄ (Arzneimittelkommission der deutschen Ärzteschaft)",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Rote Liste",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) www.dosing.de",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F17",
                    "titel" => "Pharmakologie, Toxikologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-9337",
                "durchschnittRichtig" => 0.93,
                "text" => "Welche Aussage zum Verlauf der V. ovarica trifft zu?",
                "antworten" => [
                    [
                        "text" => "a) Sie mündet in die V. lumbalis ein.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Sie hat einen gewundenen Verlauf.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Sie überkreuzt den Ureter.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Die rechte V. ovarica mündet in die V. renalis.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Sie hat eine Verbindung zur V. umbilicalis.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S03",
                    "titel" => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-9704",
                "durchschnittRichtig" => 0.82,
                "text" => "Welche der folgenden Proteinketten sind identisch?",
                "antworten" => [
                    [
                        "text" => "a) PRL und GH",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Alpha-Untereinheit von GH und TSH",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Alpha-Untereinheit von TSH und LH",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Beta-Untereinheit von LH und FSH",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Beta-Untereinheit von hCG und TSH",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S02",
                    "titel" => "Chemie, Biochemie, Molekurlarbiologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-9904",
                "durchschnittRichtig" => 0.71,
                "text" => "Ein 24-jähriger Motorradfahrer wird nach einem Auffahrunfall mit leichtem Schädel-Hirn-Trauma, stumpfem Thoraxtrauma sowie stumpfem Bauchtrauma vom Notarzt vor Ort intubiert und in die Rettungsstelle eingeliefert. Die Herzfrequenz beträgt 135/min, der arterielle Blutdruck 73/34 mmHg unter Therapie mit Noradrenalin, der initiale Hb-Wert beträgt 13g/dl, Base Excess -10mmol/l, die Körpertemperatur 35,4°C. Es werden Pneumothoraces beidseits mit mittelständigem Herz sowie massiv freie abdominelle Flüssigkeit mit Verdacht auf Milzruptur diagnostiziert. In einer Notoperation werden Thoraxdrainagen beidseits angelegt sowie eine Milzruptur mittels Splenektomie versorgt. Intraoperativ müssen 6 Erythrozytenkonzentrate und 10 gefrorene Frischplasmen (FFP) transfundiert werden. Postoperativ wird der Patient am nächsten Tag auf der Intensivstation extubiert, der Noradrenalinbedarf ist nur noch minimal, die Herzfrequenz beträgt 74/min, der arterielle Blutdruck 135/78 mmHg. Weitere zwei Tage später steigt der Noradrenalinbedarf innerhalb weniger Stunden signifikant an (verdreifacht), die Herzfrequenz beträgt 98/min, der Blutdruck 105/63 mmHg, die Körpertemperatur 38,2°C.
Wofür spricht ein positiver Schockindex (Herzfrequenz/systolischer Blutdruck >1) bei dem oben genannten Patienten am ehesten?",
                "antworten" => [
                    [
                        "text" => "a) Für das Vorliegen einer anaphylaktischen Medikamentenreaktion",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Für das Vorliegen eines hämorrhagischen Schocks",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Für das Vorliegen einer Anästhetika-induzierten Tachykardie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Für das Vorliegen einer zentral bedingten Störung des Kreislaufzentrums infolge eines Schädel-Hirn-Traumas",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F02",
                    "titel" => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-9958",
                "durchschnittRichtig" => 0.89,
                "text" => "Welches Symptom spricht bei Kindern spezifisch für das Vorliegen eines sexuellen Missbrauchs?",
                "antworten" => [
                    [
                        "text" => "a) Ängste",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Aggressives Verhalten",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Geringes Selbstwertgefühl",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Auffälliges Sexualverhalten",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Es gibt keine missbrauchsspezifische Symptomatik.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "A",
                    "titel" => "Anderes",
                    "gruppe" => "Andere"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-10245",
                "durchschnittRichtig" => 0.98,
                "text" => "Was zählt zu den typischen klinischen Zeichen des Schocks?",
                "antworten" => [
                    [
                        "text" => "a) Metabolische Alkalose",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Hypotonie, Tachykardie",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Harndrang, Polyurie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Alveoläre Hypoventilation",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F02",
                    "titel" => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-10677",
                "durchschnittRichtig" => 0.97,
                "text" => "Eine 25-Jährige bittet ihre Gynäkologin um die chirurgische Verkleinerung der Schamlippen, die nach dem Untersuchungsbefund keine auffällige Größe aufweisen. Die junge Frau erwähnt, dass ihr auch ihre Oberschenkel und die Bauchregion missfallen und beides „als nächstes drankomme“. Welche Antwort ist richtig?",
                "antworten" => [
                    [
                        "text" => "a) Gegen die Durchführung der Schamlippenverkleinerung spricht nichts, zumal es kaum Risiken gibt.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Es ist anzunehmen, dass die sexuelle und partnerschaftliche Beziehungszufriedenheit der jungen Frau hoch ist. Fragen hierzu erübrigen sich.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Es ist anzunehmen, dass die sexuelle und partnerschaftliche Beziehungszufriedenheit gering ist. Fragen hierzu verbieten sich deshalb.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Es ist denkbar, dass bei der jungen Frau eine Selbstwertproblematik vorliegt, die sich auf das körperliche und sexuelle Erleben ausgedehnt hat.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) Ärztliche Hinweise auf mögliche Komplikationen schönheitschirurgischer Eingriffe erweisen sich meist als wirksam und führen zu einer Distanzierung von derartigen Wünschen.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "A",
                    "titel" => "Anderes",
                    "gruppe" => "Andere"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-10733",
                "durchschnittRichtig" => 0.77,
                "text" => "Was kann mit einem Insulin-Hypoglykämietest überprüft werden?",
                "antworten" => [
                    [
                        "text" => "a) Die TRH-PRL-Achse",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Die Oxytocin-Achse",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Die GH-IGF-Achse",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Die Schilddrüsenhormonachse",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Keine dieser endokrinen Achsen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F11",
                    "titel" => "Innere Medizin",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-10921",
                "durchschnittRichtig" => 0.54,
                "text" => "Welche anatomische Region in einem gesunden Probanden lässt sich im Rahmen der digital-rektalen Untersuchung mit einer durchschnittlichen Untersucherfingerlänge von 6 cm erreichen?",
                "antworten" => [
                    [
                        "text" => "a) rektosigmoidaler Übergang",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) oberes Rektumdrittel",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) mittleres Rektumdrittel",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) unteres Rektumdrittel",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) alle oben angeführten Regionen",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "F07",
                    "titel" => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-10982",
                "durchschnittRichtig" => 0.85,
                "text" => "Diese Frage bezieht sich auf die Abbildung 10982 in der Bildbeilage:---
Nach welchem Behandlungsprinzip hatte der Notarzt am ehesten eine Noradrenalingabe bei dem Patienten indiziert? (Falltext siehe Bildbeilage, Abbildung 10982)",
                "antworten" => [
                    [
                        "text" => "a) Symptomatische Therapie einer Hypothermie: Verminderung des Wärmeverlustes durch periphere Vasokonstriktion",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Symptomatische Therapie einer Hypotension: Anhebung des peripheren Gefäßwiderstandes zur Sicherstellung eines ausreichenden arteriellen Blutdrucks",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Kausale Therapie einer Hypotension: Verminderung des Blutverlustes durch lokale Vasokonstriktion",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Symptomatische Therapie eines Schocks: Steigerung der kardialen Inotropie durch katecholamin-induzierte Tachykardie (Bedarfstachykardie)",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) Kausale Therapie eines relativen Mangels endogener Katecholamine infolge einer Nebennierenmarksinsuffizienz auf dem Boden einer retroperitonealen Blutung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F02",
                    "titel" => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-11035",
                "durchschnittRichtig" => 0.95,
                "text" => "Welcher der folgenden Therapiegrundsätze ist in der Akutversorgung eines traumatisierten Notfallpatienten (z.B. bei einem schweren Verkehrsunfall) -nicht---- relevant?",
                "antworten" => [
                    [
                        "text" => "a) Volumengabe zum Ausgleich von Blut- und Flüssigkeitsverlusten",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Sicherstellung eines ausreichenden arteriellen Blutdrucks zur Gewebeperfusion",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Reposition von Frakturen am Unfallort",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Analgetische Therapie am Unfallort",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Einholung einer Behandlungseinwilligung (ggf. durch einen gesetzlichen Betreuer), wenn der Patientenwille nicht offensichtlich erkennbar ist",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "F02",
                    "titel" => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-12052",
                "durchschnittRichtig" => 0.98,
                "text" => "Was ist ein typisches Zeichen für eine anaphylaktische Reaktion?",
                "antworten" => [
                    [
                        "text" => "a) Bradykardie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Blasse Haut",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Atemnot durch Bronchospasmus",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Hypoxämie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Pulmonale Hypotension",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F17",
                    "titel" => "Pharmakologie, Toxikologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-12378",
                "durchschnittRichtig" => 0.83,
                "text" => "Welche der folgenden Aussagen beschreibt die physiologische Lage des Uterus am ehesten?",
                "antworten" => [
                    [
                        "text" => "a) Anteversio und Retroflexio",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Retroversio und Anteflexio",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Retroversio und Retroflexio",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Anteversio und Anteflexio",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "S03",
                    "titel" => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-13017",
                "durchschnittRichtig" => 0.9,
                "text" => "Welche Faktoren werden für die Entstehung einer Kachexie im Verlauf einer Tumorerkrankung mitverantwortlich gemacht?",
                "antworten" => [
                    [
                        "text" => "a) erhöhte Konzentrationen von TNFa, IL6, Katecholaminen, Cortisol",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) erhöhte Konzentrationen von Insulin, T3, IGF",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) erniedrigte Konzentrationen von Lipidmobilisierendem Faktor (LMF) und Proteolyse-induzierendem Faktor (PIF)",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F11",
                    "titel" => "Innere Medizin",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-13137",
                "durchschnittRichtig" => 0.91,
                "text" => "Wodurch wird die belohnende Wirkung prosozialer Interaktionen auf zentralnervöser Ebene vermittelt?",
                "antworten" => [
                    [
                        "text" => "a) Über die Ausschüttung von Oxytocin aus dem Hypothalamus, welches an Oxytocin-Rezeptoren in dopaminergen Strukturen des Gehirns bindet.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Über die Ausschüttung von Oxytocin aus dem Hypothalamus, welches an Oxytocin-Rezeptoren in  serotonergen Strukturen des Gehirns bindet.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Über die Ausschüttung von Oxytocin aus dem Hippocampus, welches an Oxytocin-Rezeptoren in  dopaminergen Strukturen des Gehirns bindet.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Über die Ausschüttung von Oxytocin aus dem Hippocampus, welches an Oxytocin-Rezeptoren in serotonergen Strukturen des Gehirns bindet.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S04",
                    "titel" => "Psychologie, Soziologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-13252",
                "durchschnittRichtig" => 0.5,
                "text" => "Bei einem 65-jährigen Patienten wird eine beidseitige Adrenalektomie wegen eines Nierenzellkarzinoms mit Nebennierenmetastase auf der kontralateralen Seite notwendig. Danach besteht eine primäre Nebenniereninsuffizienz. Welche Kombination von Medikamenten sollte in der weiteren Therapie der Nebenniereninsuffizienz eingesetzt werden, vorausgesetzt es besteht keine außergewöhnliche psychische oder körperliche Belastung (z.B. Infektion, Fieber, starker psychischer Stress)?",
                "antworten" => [
                    [
                        "text" => "a) Hydrocortison und Fludrocortison",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Hydrocortison und Dexamethason",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Monotherapie mit Hydrocortison",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Monotherapie mit Fludrocortison",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F11",
                    "titel" => "Innere Medizin",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-13930",
                "durchschnittRichtig" => 0.73,
                "text" => "In welchen Schritten erfolgt die Entwicklung einer Differentialdiagnose?",
                "antworten" => [
                    [
                        "text" => "a) Datenerhebung – Problembeschreibung – Liste von Differentialdiagnosen",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Blickdiagnose – alternative „must not miss“ - Diagnosen – diagnostische Aufarbeitung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Leitsymptom festlegen  – Vorgeschichte erfassen – Diagnoseliste aus elektronischer Datenbank (z.B. up-to-date®) erstellen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Vordiagnose (z.B. des Zuweisers) erfassen – diagnostische Überprüfung – ggf. alternative Verdachtsdiagnosen formulieren",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "F11",
                    "titel" => "Innere Medizin",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-14219",
                "durchschnittRichtig" => 0.41,
                "text" => "Diese Frage bezieht sich auf die Abbildung 14219 in der Bildbeilage:---
Um welche Art von Verdichtungsmuster handelt es sich bei diesem axialen computertomographischen Schnitt in der rechten Lunge?",
                "antworten" => [
                    [
                        "text" => "a) inhomogenes, alveoläres Verdichtungsmuster",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) inhomogenes, interstitielles Verdichtungsmuster",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) homogene, scharf begrenzte Verdichtung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) homogene, unscharf begrenzte Verdichtung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "Q11",
                    "titel" => "Bildgebende Verfahren, Strahlenbehandlung",
                    "gruppe" => "Querschnittsfächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-14240",
                "durchschnittRichtig" => 0.61,
                "text" => "Welche bildgebende Methode ist für die Darstellung der Nebennieren bei einem Patienten mit einer Kontraindikation für eine MRT und Verdacht auf ein Phäochromozytom am besten geeignet?",
                "antworten" => [
                    [
                        "text" => "a) Röntgen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Ultraschall",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) native Computertomographie",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Mehrphasen-Computertomographie",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "Q11",
                    "titel" => "Bildgebende Verfahren, Strahlenbehandlung",
                    "gruppe" => "Querschnittsfächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-15046",
                "durchschnittRichtig" => 0.27,
                "text" => "Was ist das Markerhormon für eine adrenale Hyperandrogenämie?",
                "antworten" => [
                    [
                        "text" => "a) Cortisol",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Dehydroepiandrosteronsulfat (DHEAS)",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Testosteron",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) 17alpha-Hydroxyprogesteron",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Östron",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F12",
                    "titel" => "Kinderheilkunde",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-15112",
                "durchschnittRichtig" => 0.77,
                "text" => "Welche Hormonkonstellation findet sich physiologischerweise in der Postmenopause?",
                "antworten" => [
                    [
                        "text" => "a) FSH niedrig und Estradiol niedrig",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) FSH hoch und Estradiol hoch",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) FSH hoch und Estradiol niedrig",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) LH niedrig und Estradiol hoch",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F07",
                    "titel" => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-15261",
                "durchschnittRichtig" => 0.57,
                "text" => "Ein 17-jähriges Mädchen kommt in die gynäkologische Sprechstunde, weil die Menarche noch nicht aufgetreten sei. Die sekundären Geschlechtsmerkmale sind normal ausgebildet, auch das äußere weibliche Genitale ist unauffällig. Da sie noch Virgo ist, führen Sie einen abdominalen Ultraschall durch und können keine Gebärmutter darstellen. Was ist die wahrscheinlichste Verdachtsdiagnose?",
                "antworten" => [
                    [
                        "text" => "a) Hymenalatresie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) konstitutionelle späte Pubertät",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) angeborene Hypoplasie von Vagina und Uterus",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Androgen-Insistivitäts-Syndrom",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Turner-Syndrom",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F07",
                    "titel" => "Frauenheilkunde, Geburtshilfe",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-16051",
                "durchschnittRichtig" => 0.78,
                "text" => "Was kommt bei Angabe von kolikartigen Schmerzen am ehesten als pathophysiologischer Mechanismus in Betracht?",
                "antworten" => [
                    [
                        "text" => "a) Entzündung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Ischämie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Hohlorganperforation",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Hohlorgandistension",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Blutung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F11",
                    "titel" => "Innere Medizin",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-16313",
                "durchschnittRichtig" => 0.76,
                "text" => "Was ist eine sinnvolle Präventionsmaßnahme beim Erschöpfungssyndrom im Sinne eines Burn-out?",
                "antworten" => [
                    [
                        "text" => "a) Jährliche Check-ups beim Hausarzt/bei der Hausärztin",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Abschied von Perfektionismus",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Selbstvermessungs-App",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Sauerstoff-Therapie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "A",
                    "titel" => "Anderes",
                    "gruppe" => "Andere"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-17023",
                "durchschnittRichtig" => 0.95,
                "text" => "Auf welche akute, unerwünschte Wirkung weisen die Symptome Übelkeit mit Erbrechen, Rückenschmerzen, Blutdruckabfall, Hämoglobinurie kurz nach Beginn einer Erythrozytentransfusion hin?",
                "antworten" => [
                    [
                        "text" => "a) anaphylaktische Reaktion auf Plasmaproteine im Erythrozytenkonzentrat",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) transfusionsassoziierte Volumenüberladung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) hämolytische Transfusionsreaktion (AB0-Verwechslung)",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) febrile nicht-hämolytische Transfusionsreaktion",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Volumenmangelschock aufgrund eines akuten Blutverlustes",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F13",
                    "titel" => "Klinische Chemie, Laboratoriumsdiagnostik",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-17188",
                "durchschnittRichtig" => 0.7,
                "text" => "Wieviel Prozent der täglichen Sekretion von Wachstumshormon erfolgt während des Schlafes?",
                "antworten" => [
                    [
                        "text" => "a) < 10 %",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) ca. 20 %",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) ca. 40 %",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) ca. 60 %",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) > 70 %",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S01",
                    "titel" => "Physik, Physiologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-17842",
                "durchschnittRichtig" => 0.72,
                "text" => "Welcher Untersuchungsbefund differenziert eindeutig zwischen einem Patienten mit einem Locked-in-Syndrom und einem komatösen Patienten?",
                "antworten" => [
                    [
                        "text" => "a) Tetraparese",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) ausgefallene Bauchhautreflexe in allen Etagen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) schlaffer Muskeltonus",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) vertikale Augenbewegungen bei Ansprache",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) ausgefallener vestibulo-okulärer Reflex",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F14",
                    "titel" => "Neurologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-18100",
                "durchschnittRichtig" => 0.86,
                "text" => "Welche bildgebende Methode ist für eine schnelle orientierende Diagnostik beim akuten Abdomen sinnvoll?",
                "antworten" => [
                    [
                        "text" => "a) MRT des Abdomens",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Gastrografinschluck",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Röntgen-Abdomenübersichtsaufnahme",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Digitale Subtraktionsangiographie der Mesenterialarterien",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Nierenszintigraphie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "Q11",
                    "titel" => "Bildgebende Verfahren, Strahlenbehandlung",
                    "gruppe" => "Querschnittsfächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-18311",
                "durchschnittRichtig" => 0.69,
                "text" => "Diese Frage bezieht sich auf die Abbildung 18311 in der Bildbeilage:---
Nebenstehende Abbildung zeigt einen Ausschnitt aus einem endokrinen Organ. Zu welcher Stoffgruppe gehören die in dem mit einem Stern markierten Bereich gebildeten Hormone?",
                "antworten" => [
                    [
                        "text" => "a) biogene Amine",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Glykoproteine",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Polypeptide",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Steroide",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S03",
                    "titel" => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-18317",
                "durchschnittRichtig" => 0.95,
                "text" => "Die Eltern eines erkrankten Kindes mit Adrenogenitalem Syndrom sind beide Überträger für das Adrenogenitale Syndrom. Bei jetzt erneuter Schwangerschaft wird die Mutter in der 4. SSW unmittelbar nach Feststellung der Schwangerschaft mit Dexamethason behandelt. Welche Konsequenz hat die pränatale Diagnostik mittels der in der 11. SSW durchgeführten Chorionzottenbiopsie?",
                "antworten" => [
                    [
                        "text" => "a) Es kann über die Fortführung oder Beendigung der Therapie mit Dexamethason entschieden werden.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Es kann bei einem weiblichen Fötus eine Substitutionstherapie mit Östrogenen begonnen werden.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Es kann bei einem männlichen Fötus eine Substitutionstherapie mit Testosteron begonnen werden.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Es kann bei einem männlichen Neugeborenen unmittelbar nach der Geburt eine sofortige operative Korrektur der Genitalien in einem dafür spezialisierten Zentrum organisiert werden.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F12",
                    "titel" => "Kinderheilkunde",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-18344",
                "durchschnittRichtig" => 0.86,
                "text" => "Ein 69-jähriger Patient stellt sich mit einer schmerzlosen Hämaturie bei Ihnen in der Rettungsstelle vor. Sie führen eine ausführliche Anamnese und gründliche körperliche Untersuchung durch. Ein Labor inklusive Blutbild und Serumretentionswerten wurde bereits abgenommen. Welche weiterführende Untersuchung ist in diesem Fall umgehend indiziert?",
                "antworten" => [
                    [
                        "text" => "a) CT von Abdomen und Becken",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Ultraschall von Harnblase und Nieren",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Urinzytologie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Miktionszysturethrogramm",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Harnstrahlmessung (Uroflow)",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F21",
                    "titel" => "Urologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-19526",
                "durchschnittRichtig" => 0.94,
                "text" => "Den sog. Nürnberger Kodex formulierten die Richter im Nürnberger Ärzteprozess von 1947, um eine Beurteilungsbasis für die NS-Medizinverbrechen zu haben. Worin besteht die wesentliche Grundlage der juristischen Beurteilung des Kodex?",
                "antworten" => [
                    [
                        "text" => "a) Zentral sind Wohl und Schutz des einzelnen Menschen.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Zentral sind optimale Rahmenbedingungen für Forschung und Lehre.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Zentral sind Wohlergehen und gedeihliches Miteinander der Gemeinschaft.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Zentral sind Forschungsfreiheit und wissenschaftlicher Fortschritt.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "A",
                    "titel" => "Anderes",
                    "gruppe" => "Andere"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20422",
                "durchschnittRichtig" => 0.43,
                "text" => "Was verändert sich bei der Mikrozirkulation durch einen Volumenmangelschock?",
                "antworten" => [
                    [
                        "text" => "a) Der onkotische Druck des Plasmas nimmt ab und steigert dadurch die Flüssigkeitsaufnahme aus dem interstitiellen Raum in die Kapillare.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Der hydrostatische Druck des Plasmas in der Kapillare nimmt ab und steigert dadurch die Flüssigkeitsaufnahme aus dem interstitiellen Raum in die Kapillare.",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Die präkapillären Arteriolen dilatieren, um die Peripherie mit hinreichend Sauerstoff zu versorgen.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Die postkapillären Venolen konstringieren, um die Flüssigkeitsaufnahme aus dem interstitiellen Raum in die Kapillare zu erhöhen.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Die arteriovenösen Shunts der Hautgefäße dilatieren, um das Blutvolumen zu zentralisieren.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S01",
                    "titel" => "Physik, Physiologie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20429",
                "durchschnittRichtig" => 0.95,
                "text" => "Was beinhaltet die Beziehungsdimension menschlicher Sexualität?",
                "antworten" => [
                    [
                        "text" => "a) Monogamie, Selbstbefriedigung, sexuelle Fantasie und sexuelles Verhalten",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Akzeptanz, Nähe, Wärme, Geborgenheit",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "c) Wohnung, finanzielle Sicherheit, Karrieremöglichkeit, Nahrung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Affekt, Mnestik, örtliche und zeitliche Orientierung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "A",
                    "titel" => "Anderes",
                    "gruppe" => "Andere"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20550",
                "durchschnittRichtig" => 0.94,
                "text" => "Welche endokrin wirkende und im Ovar lokalisierte Struktur sorgt ab der 2. Zyklushälfte für die Vorbereitung der Gebärmutterschleimhaut auf die Nidation?",
                "antworten" => [
                    [
                        "text" => "a) dominanter Tertiärfollikel",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Primärfollikel",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Sekundärfollikel",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Corpus luteum",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) Corpus albicans",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S03",
                    "titel" => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20551",
                "durchschnittRichtig" => 0.79,
                "text" => "Wo endet der Verlauf des im Tubenwinkel entspringenden Lig. teres uteri?",
                "antworten" => [
                    [
                        "text" => "a) Labia majora",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) laterale Beckenwand",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Os pubis",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Os sacrum",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Harnblasenwandung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "S03",
                    "titel" => "Biologie, Anatomie",
                    "gruppe" => "Vorklinische Fächer"
                ],
                "modul" => [
                    "code" => "M22",
                    "titel" => "Modul 22"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20641",
                "durchschnittRichtig" => 0.92,
                "text" => "Eine 55-jährige, normalgewichtige Patientin mit bekannter Depression und arterieller Hypertonie wird derzeit mit einem Antidepressivum (Mirtazapin 30 mg) und einem Antihypertensivum (Ramipril 5mg) behandelt. Hierunter hat sich ihre Stimmung deutlich verbessert und die Blutdruckwerte liegen im normotonen Bereich. Die Patientin beklagt jedoch eine vermehrte Tagesmüdigkeit. Was ist die wahrscheinlichste Ursache für die von der Patientin beschriebene Symptomatik?",
                "antworten" => [
                    [
                        "text" => "a) Medikamentennebenwirkungen",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "b) Chronic Fatigue Syndrom",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Fatigue als Folge einer Herzinsuffizienz",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Schlafbezogene Atemstörung",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "A",
                    "titel" => "Anderes",
                    "gruppe" => "Andere"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20682",
                "durchschnittRichtig" => 0.87,
                "text" => "Diese Frage bezieht sich auf die Abbildung 20682 in der Bildbeilage:---
Sie werden als diensthabender Arzt auf der Intensivstation im Rahmen der Besetzung des hausinternen Reanimationsdienstes auf die viszeralchirurgische Normalstation zu einem Patienten bei Z.n. Transverso-Rektostomie bei Koloncarzinom des Colon descendens vor 5 Tagen gerufen. Bei Ankunft finden Sie einen leblosen Patienten vor. Die Kollegen der Viszeralchirurgie haben bereits mit der kardiopulmonalen Reanimation begonnen. Sie schließen zügig Ihren transportablen Defibrillator an. Es stellt sich das unten aufgeführte EKG dar. 
Was ist die Therapie der Wahl?",
                "antworten" => [
                    [
                        "text" => "a) Gabe von 1 mg Adrenalin intravenös",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Gabe von 300 mg Amiodaron intravenös",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Sofortige Defibrillation und anschließende erneute Rhythmusanalyse mit Beendigung der Herzdruckmassage",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Sofortige Defibrillation, gefolgt von einer Herzdruckmassage mittels 30 Thoraxkompressionen und 2 Beatmungen mittels Ambu-Beutel und Maske über 5 Zyklen und hiernach erneute Rhythmusanalyse",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ]
                ],
                "fach" => [
                    "code" => "F02",
                    "titel" => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20686",
                "durchschnittRichtig" => 0.15,
                "text" => "Was gehört zu den grundlegenden Therapieprinzipien einer disseminierten intravasalen Gerinnung (DIC)?",
                "antworten" => [
                    [
                        "text" => "a) Erhalten eines hohen Niveaus an Inhibitoren der Blutgerinnung.",
                        "richtig" => true,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Heparingabe auch bei blutenden Patienten.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Substitution von Thrombozyten, wenn die Thrombozytenzahl < 100.000/µl ist.",
                        "richtig" => false,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "d) Gabe von Antithrombin, wenn Antithrombin-III-Spiegel < 70% der Norm.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "e) Gabe von Prothrombinkonzentrat, wenn Antithrombin-III-Spiegel > 70% der Norm.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F02",
                    "titel" => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20688",
                "durchschnittRichtig" => 0.68,
                "text" => "Welche Maßnahme wird zur Optimierung des perioperativen Hämoglobinspiegels eingesetzt?",
                "antworten" => [
                    [
                        "text" => "a) Häufige Durchführung von Routinelaborentnahmen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Maximierung der Sauerstoffversorgung mittels Dobutamin",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Aufrechterhaltung einer Normovolämie",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Intraoperative autologe Blutrückgewinnung (Cell-Saver)",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) Prophylaktische Gabe von Tranexamsäure bei jeder Operation",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F02",
                    "titel" => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20741",
                "durchschnittRichtig" => 0.22,
                "text" => "Eine 25-jährige ansonsten gesunde Patientin stellt sich 14 Tage nach einer Sportverletzung am rechten oberen Sprunggelenk bei Ihnen vor. Das betroffene Bein ist geschwollen und schmerzhaft gerötet. Sie berichtet, vor einigen Stunden eine Episode akuter Luftnot erlitten zu haben, die sich spontan gebessert habe. Der Blutdruck liegt aktuell bei 110/60 mmHg, die Herzfrequenz beträgt 95/min, die Atemfrequenz beträgt 18/min, das kardiale Troponin ist negativ, eine Echokardiographie steht akut nicht zur Verfügung. Ihre Verdachtsdiagnose lautet tiefe Beinvenenthrombose mit komplizierender Lungenarterienembolie. In welche Risikokategorie ist die Patientin einzuordnen und welche Therapie folgt daraus?",
                "antworten" => [
                    [
                        "text" => "a) Hohes Risiko - Fibrinolyse",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Intermediär hohes Risiko – Antikoagulation, Fibrinolyse erwägen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Intermediär niedriges Risiko - Antikoagulation",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Niedriges Risiko – Antikoagulation, ambulante Behandlung möglich",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) Ohne Echokardiographie ist eine Einteilung des Risikos und Ableitung der Therapie hier nicht möglich.",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F02",
                    "titel" => "Anästhesiologie",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ],
            [
                "id" => "MC-Sem6-201721-20955",
                "durchschnittRichtig" => 0.72,
                "text" => "Ihnen wird ein 3-jähriges, atemnötiges Kleinkind vorgestellt. Die Mutter berichtet, dass die Symptomatik nach dem Essen aufgetreten sei. Welche anamnestische Angabe bzw. welcher Untersuchungsbefund spricht eher für eine Fremdkörperaspiration als für eine anaphylaktische Reaktion?",
                "antworten" => [
                    [
                        "text" => "a) Verzehr von Erdnüssen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "b) Expiratorischer Stridor",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "c) Giemen und Brummen",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ],
                    [
                        "text" => "d) Plötzlicher Husten",
                        "richtig" => true,
                        "ausgewaehlt" => true
                    ],
                    [
                        "text" => "e) Beidseits abgeschwächtes Atemgeräusch",
                        "richtig" => false,
                        "ausgewaehlt" => false
                    ]
                ],
                "fach" => [
                    "code" => "F12",
                    "titel" => "Kinderheilkunde",
                    "gruppe" => "Klinische Fächer"
                ],
                "modul" => [
                    "code" => "M21",
                    "titel" => "Modul 21"
                ]
            ]
        ]
    ];

}