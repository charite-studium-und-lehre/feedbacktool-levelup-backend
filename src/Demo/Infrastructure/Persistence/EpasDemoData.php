<?php

namespace Demo\Infrastructure\Persistence;

class EpasDemoData extends AbstractJsonDemoData
{
    protected array $jsonData = [
        "epas" => [
            [
                "id"           => 100,
                "beschreibung" => "Betreuung von Patienten",
                "parentId"     => NULL,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 200,
                "beschreibung" => "Ärztliche Prozeduren",
                "parentId"     => NULL,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 300,
                "beschreibung" => "Kommunikation mit Patienten",
                "parentId"     => NULL,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 400,
                "beschreibung" => "Kommunikation und Zusammenarbeit mit Kollegen",
                "parentId"     => NULL,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 500,
                "beschreibung" => "Weitere ärztliche professionelle Tätigkeit",
                "parentId"     => NULL,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 110,
                "beschreibung" => "Anamnese erheben, körperliche Untersuchung durchführen und Ergebnisse strukturiert zusammenfassen",
                "parentId"     => 100,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 120,
                "beschreibung" => "Diagnostischen Arbeitsplan erstellen und Umsetzung einleiten",
                "parentId"     => 100,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 130,
                "beschreibung" => "Untersuchungsergebnisse interpretieren und weiterführende Schritte einleiten",
                "parentId"     => 100,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 140,
                "beschreibung" => "Behandlungsplan erstellen und die Umsetzung einleiten",
                "parentId"     => 100,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 310,
                "beschreibung" => "Einverständnis für Untersuchungen und Prozeduren einholen (Patienten über Ablauf, Nutzen, Risiken, Alternativen informieren)",
                "parentId"     => 300,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 320,
                "beschreibung" => "Patienten informieren und beraten (häufige Beratungsanlässe und Krankheitsbilder)",
                "parentId"     => 300,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 410,
                "beschreibung" => "Krankengeschichte eines Patienten vorstellen (strukturiert, entsprechend Zielpersonen und Situationserfordernissen)",
                "parentId"     => 400,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 420,
                "beschreibung" => "Patientenübergabe vornehmen oder entgegennehmen (strukturiert, entsprechend Zielpersonen und Situationserfordernissen)",
                "parentId"     => 400,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 430,
                "beschreibung" => "Patientenbericht verfassen und übermitteln (strukturiert, entsprechend der Abstimmung mit dem supervidierenden Arzt zur medizinischen Versorgung des Patienten)",
                "parentId"     => 400,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 510,
                "beschreibung" => "Notfallsituationen erkennen und handeln (Ausmaß grob abschätzen, Soforthilfe leisten, Hilfe herbeirufen)",
                "parentId"     => 500,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 520,
                "beschreibung" => "Fallvorstellung evidenz-basiert vornehmen und patientenbezogene Umsetzung einleiten (für PJ´ler bearbeitbare medizinische Problemstellungen)",
                "parentId"     => 500,
                "istBlatt"     => FALSE,
            ],
            [
                "id"           => 111,
                "beschreibung" => "Vollständige oder fokussierte Anamnese erheben und körperliche Untersuchung durchführen (entsprechend Situationsanforderung)",
                "parentId"     => 110,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 112,
                "beschreibung" => "Zusammenstellen von Vorbefunden, Dokumenten, Medikation, ggf. Rücksprache mit behandelnden Ärzten oder Familienangehörigen",
                "parentId"     => 110,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 113,
                "beschreibung" => "Strukturierte Dokumentation in Patientenakte, einschließlich Synthese von Diagnosen/Arbeitsdiagnosen und wesentlicher Differentialdiagnosen",
                "parentId"     => 110,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 121,
                "beschreibung" => "Eintrag für die Basisdiagnostik in Patientenkurve vorschreiben (Gegenzeichnung Arzt)",
                "parentId"     => 120,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 122,
                "beschreibung" => "Plan für die patientenspezifische Diagnostik entwerfen (Abstimmung mit Arzt)",
                "parentId"     => 120,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 123,
                "beschreibung" => "Plan in Patientenkurve eintragen und diagnostische Anforderungsformulare ausfüllen (Gegenzeichnung Arzt)",
                "parentId"     => 120,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 131,
                "beschreibung" => "Ergebnisse der Basisdiagnostik und häufiger Untersuchungen sichten und interpretieren",
                "parentId"     => 130,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 132,
                "beschreibung" => "Änderungen in Diagnostik und Therapie vorschlagen (Abstimmung mit Arzt)",
                "parentId"     => 130,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 133,
                "beschreibung" => "Ergebnisse in Patientenkurve eintragen und ggf. Anforderungsformulare ausfüllen (Gegenzeichnung Arzt)",
                "parentId"     => 130,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 141,
                "beschreibung" => "Eintrag für die allgemeine Therapie in Patientenkurve vorschreiben (Gegenzeichnung Arzt)",
                "parentId"     => 140,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 142,
                "beschreibung" => "Plan für die patientenspezifische Therapie entwerfen (Abstimmung mit Arzt)",
                "parentId"     => 140,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 143,
                "beschreibung" => "Plan in Patientenkurve eintragen und therapeutische Anforderungsformulare ausfüllen (Gegenzeichnung Arzt)",
                "parentId"     => 140,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 201,
                "beschreibung" => "Venös Blut entnehmen",
                "parentId"     => 200,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 202,
                "beschreibung" => "Venenverweilkanüle legen",
                "parentId"     => 200,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 203,
                "beschreibung" => "Blutkultur entnehmen",
                "parentId"     => 200,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 204,
                "beschreibung" => "Abstriche (Mund, Nase, Wunde, anal oder urogenital) vornehmen",
                "parentId"     => 200,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 205,
                "beschreibung" => "Infusion anlegen",
                "parentId"     => 200,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 206,
                "beschreibung" => "12-Kanal EKG schreiben",
                "parentId"     => 200,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 207,
                "beschreibung" => "Einfachen Verband anlegen oder wechseln ",
                "parentId"     => 200,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 208,
                "beschreibung" => "Rezept vorschreiben (Gegenzeichnung Arzt)",
                "parentId"     => 200,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 311,
                "beschreibung" => "Nicht-unterschreibungspflichtige Untersuchungen/Prozeduren (z.B. Blutentnahmen, Blasenkatheter, Magensonde, Röntgen-Untersuchungen)",
                "parentId"     => 310,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 312,
                "beschreibung" => "Unterschriftspflichtige Prozeduren mit Gegenzeichung des Arztes (Gabe von Erythrozyten, Thrombozyten oder Plasmapräparaten)",
                "parentId"     => 310,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 321,
                "beschreibung" => "Informieren des Patienten (allgemeine Information zu Art der Beschwerden, dem Krankheitsbild und der Diagnostik und Therapie",
                "parentId"     => 320,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 322,
                "beschreibung" => "Informieren des Patienten (allgemeine Information zu Art der Beschwerden, dem Krankheitsbild und der Diagnostik und Therapie; spezifische Informationen zum Patienten hierzu wie mit dem Arzt abgestimmt)",
                "parentId"     => 320,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 411,
                "beschreibung" => "Krankengeschichte in Visite vorstellen ",
                "parentId"     => 410,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 412,
                "beschreibung" => "Krankengeschichte in Besprechungen vorstellen (z.B. Röntgen-Demo, Pathokonferenz, Teambesprechungen)",
                "parentId"     => 410,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 421,
                "beschreibung" => "Patientenübergabe an/von Ärzte(n) durchführen (z.B. Dienstübergaben)",
                "parentId"     => 420,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 422,
                "beschreibung" => "Patientenübergabe an/von nicht-ärztliche(n) Mitarbeiter(n) durchführen",
                "parentId"     => 420,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 431,
                "beschreibung" => "Vorläufigen Patientenbericht vorschreiben und fertigstellen (Abstimmung und Gegenzeichnung Arzt)",
                "parentId"     => 430,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 432,
                "beschreibung" => "Abschließenden Patientenbericht vorschreiben und fertigstellen (Abstimmung und Gegenzeichnung Arzt)",
                "parentId"     => 430,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 433,
                "beschreibung" => "Übermittelung von Patientenbericht an Zielbereich bzw. dessen Veranlassung",
                "parentId"     => 430,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 511,
                "beschreibung" => "Basic-Life-Support mit und ohne technische Hilfsmittel bei Ausfall von Vitalfunktionen",
                "parentId"     => 510,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 512,
                "beschreibung" => "Zustände mit drohender vitaler Gefährdung erkennen und ggf. überbrückend versorgen (Zeichen der Atemnot oder Hypoxie, Thoraxschmerz, zunehmender Bewusstseinseinschränkung, hohes Fieber, arterielle Hypo- und Hypertension, Tachy- und Bradykardie, Hypo- und Hyperglykämie, Anurie, innere und äußere Blutung, Trauma und Verletzungen)",
                "parentId"     => 510,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 521,
                "beschreibung" => "Vorbereitung der Fallvorstellung (Suche nach bester verfügbarer Evidenz, Überprüfung der klinischen Relevanz und Anwendbarkeit für den einzelnen Patienten)",
                "parentId"     => 520,
                "istBlatt"     => TRUE,
            ],
            [
                "id"           => 522,
                "beschreibung" => "Durchführung der Fallvorstellung (Strukturierte Vorstellung (z. B. Abteilungsbesprechungen, interne Fortbildungen); Anordnung der Änderungen entsprechend 1.2 „Diagnostikplan“ und 1.4 „Behandlungsplan“",
                "parentId"     => 520,
                "istBlatt"     => TRUE,
            ],
        ],
    ];

    public function isResponsibleFor(string $pathInfo): bool {
        return $pathInfo == "/api/epas";
    }
}