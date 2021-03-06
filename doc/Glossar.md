### Glossar

| Domänenbegriff         | Synonyme                           | Erklärung                                                    |
| ---------------------- | ---------------------------------- | ------------------------------------------------------------ |
| **Studienfortschritt** |     Progress                       | Darstellung des Studienerfolgs anhand abgelegter Prüfungen und erreichter Meilensteine |
| Zeitsemester           | Akademische Periode, academic term | Kalendarische Periode, in der ein Semester stattfindet.<br />Z.B. SoSe2020, WiSe2019<br />Mögliche Darstellung als Zahl ist z.B. 20201 für "SoSe2020" |
| Fachsemester           | Semester                           | Fortschreiten im Studienverlauf anhand der Regelstudienzeit. Teilweise gibt es Bedingungen (z.B. Prüfungen), um in ein bestimmtes Fachsemester eingeschrieben zu werden. |
| Studiensemester        |                                    | Semester, die seit der Einschreibung ins Studium vergangen sind (abzüglich Urlaub und andere Pausen) |
| Meilenstein            | StudiMeilenstein, Achievements     | Ereignis, das zum Studienfortschritt beiträgt und keine Prüfung ist.<br />Z.B.: Erste-Hilfe-Praktikum, Hausarbeit, Famulatur-Reife, Pflegepraktikum, M1-Äquivalenz<br /><br />Meilensteine können nicht aus Prüfungen "gewonnen" weren, die ja LevelUp sowieso speichert, sondern müssen explizit von einem System der Studienverwaltung übertragen werden |
| FortschrittsItem       |                                    | Erreichter Meilenstein oder erfolgreich abgelegte Prüfung. In der Ansicht zum Studienfortschritt gibt es einen Eintrag pro FortschrittsItem. |



| Domänenbegriff                                      | Synonyme | Erklärung                                                    |
| --------------------------------------------------- | -------- | ------------------------------------------------------------ |
| **Prüfung**                                         | Exams    | Abstraktion aller Arten von bewerteten Leistungen, die Studierende ablegen |
| Prüfungsperiode<br />(enthält PrüfungsUnterperiode) |          | Besteht aus einem →**Zeitsemester** und einer **Unterperiode**.<br />Prüfungen können pro Semester mehrfach stattfinden, z.B. die erste Prüfung und die Nachholprüfung. das legt die Unterperiode fest.<br />Mögliche Darstellung als Zahl ist z.B. 202011 für "SoSe2020, erste Periode" |
| Prüfungsformat                                      |          | Art der Prüfung, z.B. <br />**MC** (Multiple Choice): "normale" Semesterprüfung<br />**OSCE** (Objective structured clinical examination): Praktische Prüfung, die z.B. Untersuchungen etc. enthält<br /><br />**Stationenprüfung:** (Stations) Mündlich-theoretische Prüfung<br />**PTM** (Progess Test Medizin): Test, der identisch einmal pro Zeitsemester von allen Studierenden im deutschsprachigen Bereich geschrieben wird. Kann den Fortschritt im Studium besonders gut darstellen, da das Ergebnis mit steicgendem Fachsemester bzw. Studiensemester immer besser werden sollte. |
| PrüfungsItem                                        |          | Kleinste bekannte zu bewertende Einheit in einer Prüfung. In MC-Prüfungen z.B. eine Frage, beim PTM typischerweise die Punktzahl für ein Fach (weil hier keine Einzelitems rausgegeben werden) |
| ItemSchwierigkeit                                   |          | Von LevelUp berechnete Schwierigkeit eines PrüfungsItems anhand des Gesamtergebnisses der Kohorte.<br />Standard an der Charité:<br />*Schwer*: < 40% richtige Antworten<br />*Normal*: 40%-80% richtige Antworten<br />*Leicht*: > 80% richtige Antworten |
| Frage / Antwort                                     |          | Abgebildete konkrete Frage und mögliche Antworten zu einem PrüfungsItem (typischerweise MC).<br />Die Fragennummer ist die Nummer innerhalb der Prüfung.<br />Der Antwortcode ist die Kurzbezeichnung der Antwort, z.B. "a" oder "b" |

| Domänenbegriff | Synonyme      | Erklärung                                                    |
| -------------- | ------------- | ------------------------------------------------------------ |
| **Studi**      | Studierende/r | Studierende/r. Hat eine an der Universität eindeutige Matrikelnummer.<br />In LevelUp wird ein Studi repräsentiert durch einen →StudiHash |
| StudiData      |               | Stammdaten der/des Studis wie Matrikelnummer, Vorname, Nachname. Wird verwendet zur Erzeugung von →StudiHashes und zum Versenden von  ->Fremdbewertungs-Anfragen |
| StudiHash      |               | Hash, der aus StudiData und einem geheimen Wert erzeugt wurde, und einen Studi repräsentiert.<br />Nach dem erfolgreichem Login von bekannten Studis ist dieser Hash für ein Login bekannt. |
| LoginHash      |               | Hash, der aus den beim Login bekannten Daten erzeugt wird, d.h. aus dem Nutzername. Kann einem StudiHash zugeordnet werden, so dass nach dem Login bekannt ist, welche Daten von welchem →Studi angezeigt werden sollen.<br />Wenn sich die Studi-Daten ändern (Namensänderung), bleibt der Login-hash trotzdem immer konstant. Deshalb werden Informationen, die direkt in LevelUp eingegeben werden und nicht aus anderen Quellen kommen (→z.B. EPA-Bewertungen) für einen LoginHash, nicht für einen StudiHash gespeichert. |

| Domänenbegriff   | Synonyme | Erklärung                                                    |
| ---------------- | -------- | ------------------------------------------------------------ |
| **StudiPrüfung** |          | Eine von einem →Studi abgelegte →Prüfung, z.B. Prüfung von Matrikelnummer "123" für Prüfung "MC-202011".<br />Einer StudiPrüfung kann eine →Wertung (Note) zugeordnet sein. |

| Domänenbegriff       | Synonyme | Erklärung                                                    |
| -------------------- | -------- | ------------------------------------------------------------ |
| **Wertung**          |          | Konkrete Bewertung anhand von folgenden Möglichkeiten:<br />* **Prozentzahl** (z.B. OSCE-Ergebnis)<br />* **Punktzahl**: erbrachte Punkte (MC-Prüfung)<br />* **RichtigFalschWeissnicht**: Anzahl der Items, die man richtig, falsch oder mit "weiß nicht" beantwortet hat (PTM)<br />Jeder Wertung ist eine Skala zugeordnet, die den maximal erreichbaren Wert enthält. |
| ItemWertung          |          | Bewertung eines →PrüfungsItems innerhalb einer bestimmten →StudiPrüfung, z.B. Bewertung "1 Punkt" für eine Antwort auf eine MC-Frage.<br />Einer ItemWertung kann eine →Antwort zugewiesen werden, so dass darstellbar ist, was genau auf die →Frage geantwortet wurde.<br />Es ist möglich, in einer ItemWertung die durschschnittliche Wertung der Kohorte auf das jeweilige PrüfungsItem darzustellen. |
| StudiPrüfungsWertung |          | Bewertung eines →PrüfungsItems innerhalb einer bestimmten →StudiPrüfung, z.B. Bewertung "1 Punkt" für eine Antwort auf eine MC-Frage.<br />Einer ItemWertung kann eine →Antwort zugewiesen werden, so dass darstellbar ist, was genau auf die →Frage geantwortet wurde.<br />Es ist möglich, in einer StudiPrüfungsWertung die durschschnittliche Wertung der Kohorte für die jeweilige StudiPrüfungsWertung darzustellen. |

| Domänenbegriff   | Synonyme       | Erklärung                                                    |
| ---------------- | -------------- | ------------------------------------------------------------ |
| **Cluster**      | Tag, Kategorie | Eine Markierung, die an PrüfungsItems gehängt werden kann, wie z.B. "Fach Anatomie" |
| ClusterZuordnung |                | Eine PrüfungsItem kann beliebig vielen Clustern zugeordnet sein. Dafür gibt es eine eigene "ClusterZuordnung", die Cluster und PrüfungsItem verbindet |
| ClusterTyp       |                | Zusammenfassung aller Cluster eines Typs, die untereinander vergleichbar sind.<br />Z.B. "Anatomie" und "Chirurgie" gehören beide zum ClusterTyp "Fach"<br />Z.B. "Modul 1" und "Modul 2" gehören zum ClusterTyp "Modul"<br />Cluster und ClusterTypen sind dynamisch in der DB gespeichert. Weil man in der Darstellung darauf Bezug nehmen will (z.B. Vergleich Ergebnisse nach Fach in PTM und MC), sind die Typen auch im Quellcode bekannt. |
| ClusterCode      |                | Kurzform für einen →Cluster, z.B. "F01" für "Allgemeinmedizin". Kann wichtig sein für den Import, da die Ergebnisse häufig nur die Kurzform enthalten |
| ClusterTitel     |                | Im Gegensatz zum ClusterCode die ausgeschrieben Form des Clusters, z.B. "Allgemeinmedizin" |

| Domänenbegriff         | Synonyme                                                     | Erklärung                                                    |
| ---------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **EPA**                | Entrusted Professional Activity<br />Ärztliche Tätigkeit,<br />Kompetenz | EPAs sind Kompetenzen, die angehenden Ärzten in bestimmter Tiefe zugetraut werden, bzw. die man sich selbst zutraut.<br />Z.B. "Blut abnehmen" oder "Anamnese erstellen".<br /> <a href="https://www.youtube.com/watch?v=sJWlZigz1bM">Video</a> |
| EpaKategorie           |                                                              | EPAs sind in Kategorien gruppiert, wie z.B. "Ärztliche Prozeduren" (dazu gehört Blut abnehmen) und "Kommunikation mit Patienten".<br />Für eine EPAs gibt es zusätzlich zur Kategorie noch eine Unter-Kategorie.<br />Datenstruktur: Zusammen mit den Kategorien ergeben EPAs also einen Baum. Die Blätter sind die EPAs, die inneren Knoten die Kategorien |
| EPABewertung           |                                                              | Einschätzung der Kompetenz für eine EPA. Die Einschätzzung erfolgt anhand der Level 0-5:<br />0 - keine Ausführung",                                                        <br/>1 - gemeinsam mit dem Arzt",                                                  <br/>2 - unter Beobachtung des Arztes",                                            <br/>3 - eigenständig, alles wird nachgeprüft (Arzt auf Station)",                 <br/>4 - eigenständig, Wichtiges wird nachgeprüft (Arzt auf Station)",             <br/>5 - eigenständig, Wichtiges wird nachgeprüft (Arzt nur telefonisch erreichbar) |
| Selbstbewertung        | Selbsteinschätzung                                           | Studierende schätzen ihre eigenen Fähigkeiten ein und geben eine →EPABewertung pro EPA an. Sie können dabei 2 Dinge bewerten: "habe ich  gemacht" und "traue ich mir zu". |
| SelbstbewertungsTyp    |                                                              | "Habe ich gemacht" oder "Traue ich mir zu". Entspricht den ersten 2 Spalten in den Bewertungen der EPAs in LevelUp. |
| Fremdbewertung         | Fremdeinschätzung                                            | Einschätzung des Kompetenz-Levels für eine EPA anhand eines Lehrenden. Der Lehrende wird dabei vom Studi angefragt und kann einen oder mehrere EPAs anhand der Level 0-5 bewerten. <br />In LevelUp wird die Fremdbewertung einer EPA in der dritten Spalte dargestellt. |
| FremdbewertungsAnfrage |                                                              | Anfrage eines Studis an einen Lehrenden mit der Bitte um Einschätzung der Kompetenzen. In der Anfrage ist enthalten, wer sie stellt (AnfragerName, Email), an wen sie gerichtet ist (FremdBewerterName, Email), auf welchen Kontext/Zeit sie sich bezieht (z.B. Famulatur Juli 2020), welche Tätigkeiten bewertet werden sollen und ein allgemeiner Kommentar. |

| Domänenbegriff   | Synonyme       | Erklärung                                                    |
| ---------------- | -------------- | ------------------------------------------------------------ |
| **Beratung**     | Consulting     | Sammlung von Links mit Beschreibung zum Thema Beratung für Studierende  |
| **Dashboard**    |                | Hauptansicht im Frontend, bietet auf Cards einen Überblick und Zugriff auf andere Domänen-Teile |
| **Newsfeed**     |                | Rechte Spalte im Dashboard, zeitlich geordnete Anzeige von -> StudiPrüfungen |
| **Starke Fächer** | Strengths     | Darstellung von Rankings der Studienleistungen nach verschiedenen Kriterien |
| **EvaSys** |                      | Tool für Nutzerumfragen, das in LevelUp eingebunden ist, damit die Charité-Qualitätssicherung automatisierte Umfragen machen kann |
| **FAQ** |  | frequently asked questions
