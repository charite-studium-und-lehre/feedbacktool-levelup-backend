<?php

namespace Wertung\Infrastructure\Persistence\DB\DoctrineTypes;

use Common\lib\Math\FloatToIntKodierer;
use Common\lib\Math\IntsToIntKodierer;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Exception;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\Prozentzahl;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;
use Wertung\Domain\Wertung\Wertung;

/**
 * Wertung wird wie folgt gespeichert:
 * -> BIGINT, letzte 2 Stellen geben Typ der Bewertung an
 * -> Punktskala: letzte 3-8 Stellen geben maximal erreichbare Punktzahl an, davor erreichte Punktzahl
 * -> alle Werte sind mit 100 multipliziert, um 2 Nachommastellen abbilden zu können.
 */
class WertungType extends Type
{

    const TYPE_NAME = 'wertung'; // modify to match your type name

    const PUNKT_WERTUNG = 1;
    const PROZENT_WERTUNG = 2;
    const RICHTIG_FALSCH_WEISSNICHT_WERTUNG = 3;

    const TYP_STELLEN = 2;

    const PUNKT_SKALA_STELLEN = 6;
    const RICHTIG_FALSCH_WEISSNICHT_STELLEN = 3;

    /** 2 Nachkommastellen */
    const PUNKT_SKALA_NACHKOMMASTELLEN = Punktzahl::NACHKOMMASTELLEN;

    /** 4 Nachkommastellen = 2 Nachkommastellen der Prozentzahl */
    const PROZENT_SKALA_NACHKOMMASTELLEN = 2 + Prozentzahl::NACHKOMMASTELLEN;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "BIGINT SIGNED";
    }

    /** @return Wertung */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }
        $wertunsTyp = IntsToIntKodierer::extrahiereIntAusSumme($value, 0, self::TYP_STELLEN);
        $wertungsWert = IntsToIntKodierer::extrahiereIntAusSumme($value, self::TYP_STELLEN);

        switch ($wertunsTyp) {
            case self::PUNKT_WERTUNG:
                return $this->dekodierePunktWertung($wertungsWert);
            case self::PROZENT_WERTUNG:
                return $this->dekodiereProzentWertung($wertungsWert);
            case self::RICHTIG_FALSCH_WEISSNICHT_WERTUNG:
                return $this->dekodiereRichtigFalschWeissnichtWertung($wertungsWert);
            default:
                throw new Exception("Wertungsart '" . $value % 100 . "'nicht bekannt!'");
        }
    }

    /** @return integer */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }
        if (!$value instanceof Wertung) {
            throw new Exception("Wertung muss Interface 'Wertung' implementieren!");
        }
        if ($value instanceof PunktWertung) {
            return $this->kodierePunktWertung($value);
        } elseif ($value instanceof ProzentWertung) {
            return $this->kodiereProzentWertung($value);

        } elseif ($value instanceof RichtigFalschWeissnichtWertung) {
            return $this->kodiereRichtigFalschWeissnichtWertung($value);
        }
        throw new Exception("Wertungs-Typ '" . get_class($value) . "'ist unbekannt!");
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }

    private function kodiereRichtigFalschWeissnichtWertung($value): int {
        $stellenzahlVon = 0;
        $stellenzahlBis = self::TYP_STELLEN;
        $typSummand = IntsToIntKodierer::erzeugeSummand(self::RICHTIG_FALSCH_WEISSNICHT_WERTUNG, $stellenzahlVon,
                                                        $stellenzahlBis);

        $stellenzahlVon = $stellenzahlBis;
        $stellenzahlBis +=  self::RICHTIG_FALSCH_WEISSNICHT_STELLEN;
        $richtigSummand = IntsToIntKodierer::erzeugeSummand(
            $value->getPunktzahlRichtig()->getValue(),
            $stellenzahlVon,
            $stellenzahlBis);

        $stellenzahlVon = $stellenzahlBis;
        $stellenzahlBis += self::RICHTIG_FALSCH_WEISSNICHT_STELLEN;
        $falschSummand = IntsToIntKodierer::erzeugeSummand(
            $value->getPunktzahlFalsch()->getValue(),
            $stellenzahlVon,
            $stellenzahlBis);

        $stellenzahlVon = $stellenzahlBis;
        $stellenzahlBis += self::RICHTIG_FALSCH_WEISSNICHT_STELLEN;
        $weissnichtSummand = IntsToIntKodierer::erzeugeSummand(
            $value->getPunktzahlWeissnicht()->getValue(),
            $stellenzahlVon,
            $stellenzahlBis);

        return $typSummand + $richtigSummand + $falschSummand + $weissnichtSummand;
    }

    private function kodiereProzentWertung(ProzentWertung $value): int {
        $typSummand = IntsToIntKodierer::erzeugeSummand(self::PROZENT_WERTUNG, 0, self::TYP_STELLEN);
        $prozentZahlint = FloatToIntKodierer::toInt($value->getProzentzahl()->getValue(),
                                                    self::PROZENT_SKALA_NACHKOMMASTELLEN);
        $prozentZahlSummand = IntsToIntKodierer::erzeugeSummand($prozentZahlint, self::TYP_STELLEN);

        return $typSummand + $prozentZahlSummand;
    }

    private function kodierePunktWertung(PunktWertung $value): int {
        $typSummand = IntsToIntKodierer::erzeugeSummand(self::PUNKT_WERTUNG, 0, self::TYP_STELLEN);
        $maxPunktzahlInt = FloatToIntKodierer::toInt($value->getSkala()->getMaxPunktzahl()->getValue(),
                                                     self::PUNKT_SKALA_NACHKOMMASTELLEN);
        $maxPunktzahlSummand = IntsToIntKodierer::erzeugeSummand($maxPunktzahlInt, self::TYP_STELLEN,
                                                                 self::TYP_STELLEN + self::PUNKT_SKALA_STELLEN);
        $punktzahlInt = FloatToIntKodierer::toInt($value->getPunktzahl()->getValue(),
                                                  self::PUNKT_SKALA_NACHKOMMASTELLEN);
        $punktzahlSummand = IntsToIntKodierer::erzeugeSummand($punktzahlInt, self::TYP_STELLEN +
                                                                           self::PUNKT_SKALA_STELLEN);

        return $typSummand + $maxPunktzahlSummand + $punktzahlSummand;
    }

    private function dekodierePunktWertung(int $wertungsWert): PunktWertung {
        $maxPunktzahlInt = IntsToIntKodierer::extrahiereIntAusSumme($wertungsWert, 0,
                                                                    self::PUNKT_SKALA_STELLEN);
        $maxPunktzahlFloat = FloatToIntKodierer::fromInt($maxPunktzahlInt, self::PUNKT_SKALA_NACHKOMMASTELLEN);
        $maxPunktzahl = Punktzahl::fromFloat($maxPunktzahlFloat);

        $punktzahlInt = IntsToIntKodierer::extrahiereIntAusSumme($wertungsWert, self::PUNKT_SKALA_STELLEN);
        $punktzahlFloat = FloatToIntKodierer::fromInt($punktzahlInt, self::PUNKT_SKALA_NACHKOMMASTELLEN);
        $punktzahl = Punktzahl::fromFloat($punktzahlFloat);

        $punktSkala = PunktSkala::fromMaxPunktzahl($maxPunktzahl);

        return PunktWertung::fromPunktzahlUndSkala($punktzahl, $punktSkala);
    }

    private function dekodiereProzentWertung(int $wertungsWert): ProzentWertung {
        $prozentZahlFloat = FloatToIntKodierer::fromInt($wertungsWert, self::PROZENT_SKALA_NACHKOMMASTELLEN);
        $prozentZahl = Prozentzahl::fromFloat($prozentZahlFloat);

        return ProzentWertung::fromProzentzahl($prozentZahl);
    }

    private function dekodiereRichtigFalschWeissnichtWertung(int $wertungsWert): RichtigFalschWeissnichtWertung {
        echo $wertungsWert . ";";
        $stellenzahlVon = 0;
        $stellenzahlBis = self::RICHTIG_FALSCH_WEISSNICHT_STELLEN;

        $richtigPunktzahl = IntsToIntKodierer::extrahiereIntAusSumme($wertungsWert,
                                                                     $stellenzahlVon,
                                                                     $stellenzahlBis);
        $stellenzahlVon = $stellenzahlBis;
        $stellenzahlBis = $stellenzahlBis + self::RICHTIG_FALSCH_WEISSNICHT_STELLEN;

        $falschPunktzahl = IntsToIntKodierer::extrahiereIntAusSumme($wertungsWert,
                                                                    $stellenzahlVon,
                                                                    $stellenzahlBis);
        $stellenzahlVon = $stellenzahlBis;
        $stellenzahlBis = $stellenzahlBis + self::RICHTIG_FALSCH_WEISSNICHT_STELLEN;

        $weissnichtPunktzahl = IntsToIntKodierer::extrahiereIntAusSumme($wertungsWert,
                                                                        $stellenzahlVon,
                                                                        $stellenzahlBis);

        return RichtigFalschWeissnichtWertung::fromPunktzahlen(
            Punktzahl::fromFloat($richtigPunktzahl),
            Punktzahl::fromFloat($falschPunktzahl),
            Punktzahl::fromFloat($weissnichtPunktzahl)
        );

    }
}