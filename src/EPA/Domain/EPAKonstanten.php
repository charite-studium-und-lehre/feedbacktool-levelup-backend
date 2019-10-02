<?php

namespace EPA\Domain;

class EPAKonstanten
{
    const EBENE_1 = [
        100 => "Betreuung von Patienten",
        200 => "Ärztliche Prozeduren",
        300 => "Kommunikation mit Patienten",
        400 => "Kommunikation und Zusammenarbeit mit Kollegen",
        500 => "Weitere ärztliche professionelle Tätigkeit",
    ];

    const EBENE_2 = [
        110 => "Anamnese erheben, körperliche Untersuchung durchführen und Ergebnisse strukturiert zusammenfassen",
        120 => "Diagnostischen Arbeitsplan erstellen und Umsetzung einleiten",
        130 => "Untersuchungsergebnisse interpretieren und weiterführende Schritte einleiten",
        140 => "Behandlungsplan erstellen und die Umsetzung einleiten",

        310 => "Einverständnis für Untersuchungen und Prozeduren einholen (Patienten über Ablauf, Nutzen, Risiken, Alternativen informieren)",
        320 => "Patienten informieren und beraten (häufige Beratungsanlässe und Krankheitsbilder)",

        410 => "Krankengeschichte eines Patienten vorstellen (strukturiert, entsprechend Zielpersonen und Situationserfordernissen)",
        420 => "Patientenübergabe vornehmen oder entgegennehmen (strukturiert, entsprechend Zielpersonen und Situationserfordernissen)",
        430 => "Patientenbericht verfassen und übermitteln (strukturiert, entsprechend der Abstimmung mit dem supervidierenden Arzt zur medizinischen Versorgung des Patienten)",

        510 => "Notfallsituationen erkennen und handeln (Ausmaß grob abschätzen, Soforthilfe leisten, Hilfe herbeirufen)",
        520 => "Fallvorstellung evidenz-basiert vornehmen und patientenbezogene Umsetzung einleiten (für PJ´ler bearbeitbare medizinische Problemstellungen)",
    ];

    const EPAS = [
        111 => "Vollständige oder fokussierte Anamnese erheben und körperliche Untersuchung durchführen (entsprechend Situationsanforderung)",
        112 => "Zusammenstellen von Vorbefunden, Dokumenten, Medikation, ggf. Rücksprache mit behandelnden Ärzten oder Familienangehörigen",
        113 => "Strukturierte Dokumentation in Patientenakte, einschließlich Synthese von Diagnosen/Arbeitsdiagnosen und wesentlicher Differentialdiagnosen",

        121 => "Eintrag für die Basisdiagnostik in Patientenkurve vorschreiben (Gegenzeichnung Arzt)",
        122 => "Plan für die patientenspezifische Diagnostik entwerfen (Abstimmung mit Arzt)",
        123 => "Plan in Patientenkurve eintragen und diagnostische Anforderungsformulare ausfüllen (Gegenzeichnung Arzt)",

        131 => "Ergebnisse der Basisdiagnostik und häufiger Untersuchungen sichten und interpretieren",
        132 => "Änderungen in Diagnostik und Therapie vorschlagen (Abstimmung mit Arzt)",
        133 => "Ergebnisse in Patientenkurve eintragen und ggf. Anforderungsformulare ausfüllen (Gegenzeichnung Arzt)",

        141 => "Eintrag für die allgemeine Therapie in Patientenkurve vorschreiben (Gegenzeichnung Arzt)",
        142 => "Plan für die patientenspezifische Therapie entwerfen (Abstimmung mit Arzt)",
        143 => "Plan in Patientenkurve eintragen und therapeutische Anforderungsformulare ausfüllen (Gegenzeichnung Arzt)",

        201 => "Venös Blut entnehmen",
        202 => "Venenverweilkanüle legen",
        203 => "Blutkultur entnehmen",
        204 => "Abstriche (Mund, Nase, Wunde, anal oder urogenital) vornehmen",
        205 => "Infusion anlegen",
        206 => "12-Kanal EKG schreiben",
        207 => "Einfachen Verband anlegen oder wechseln ",
        208 => "Rezept vorschreiben (Gegenzeichnung Arzt)",

        311 => "Nicht-unterschreibungspflichtige Untersuchungen/Prozeduren (z.B. Blutentnahmen, Blasenkatheter, Magensonde, Röntgen-Untersuchungen)",
        312 => "Unterschriftspflichtige Prozeduren mit Gegenzeichung des Arztes (Gabe von Erythrozyten, Thrombozyten oder Plasmapräparaten)",

        321 => "Informieren des Patienten (allgemeine Information zu Art der Beschwerden, dem Krankheitsbild und der Diagnostik und Therapie",
        322 => "Informieren des Patienten (allgemeine Information zu Art der Beschwerden, dem Krankheitsbild und der Diagnostik und Therapie; spezifische Informationen zum Patienten hierzu wie mit dem Arzt abgestimmt)",

        411 => "Krankengeschichte in Visite vorstellen ",
        412 => "Krankengeschichte in Besprechungen vorstellen (z.B. Röntgen-Demo, Pathokonferenz, Teambesprechungen)",

        421 => "Patientenübergabe an/von Ärzte(n) durchführen (z.B. Dienstübergaben)",
        422 => "Patientenübergabe an/von nicht-ärztliche(n) Mitarbeiter(n) durchführen",

        431 => "Vorläufigen Patientenbericht vorschreiben und fertigstellen (Abstimmung und Gegenzeichnung Arzt)",
        432 => "Abschließenden Patientenbericht vorschreiben und fertigstellen (Abstimmung und Gegenzeichnung Arzt)",
        433 => "Übermittelung von Patientenbericht an Zielbereich bzw. dessen Veranlassung",

        511 => "Basic-Life-Support mit und ohne technische Hilfsmittel bei Ausfall von Vitalfunktionen",
        512 => "Zustände mit drohender vitaler Gefährdung erkennen und ggf. überbrückend versorgen (Zeichen der Atemnot oder Hypoxie, Thoraxschmerz, zunehmender Bewusstseinseinschränkung, hohes Fieber, arterielle Hypo- und Hypertension, Tachy- und Bradykardie, Hypo- und Hyperglykämie, Anurie, innere und äußere Blutung, Trauma und Verletzungen)",

        521 => "Vorbereitung der Fallvorstellung (Suche nach bester verfügbarer Evidenz, Überprüfung der klinischen Relevanz und Anwendbarkeit für den einzelnen Patienten)",
        522 => "Durchführung der Fallvorstellung (Strukturierte Vorstellung (z. B. Abteilungsbesprechungen, interne Fortbildungen); Anordnung der Änderungen entsprechend 1.2 „Diagnostikplan“ und 1.4 „Behandlungsplan“",
    ];

}