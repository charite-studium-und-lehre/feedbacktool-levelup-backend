<?php

namespace Wertung\Infrastructure\Persistence\DB\DoctrineTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\Prozentzahl;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Domain\Wertung\Wertung;

/**
 * Wertung wird wie folgt gespeichert:
 * -> BIGINT, letzte 2 Stellen geben Typ der bewertung an
 * -> Punktskala: letzte 3-8 Stellen geben maximal erreichbare Punktzahl an, davor erreichte Punktzahl
 * -> alle Werte sind mit 100 multipliziert, um 2 Nachommastellen abbilden zu können.
 */
class WertungType extends Type
{

    const TYPE_NAME = 'wertung'; // modify to match your type name

    const PUNKT_WERTUNG = 1;
    const PROZENT_WERTUNG = 2;

    const TYP_FAKTOR = 10 ** 2;

    const PUNKT_SKALA_FAKTOR = 10 ** 6;
    const PUNKT_SKALA_GENAUIGKEIT = 10 ** Punktzahl::NACHKOMMASTELLEN; // 2 Nachkommastellen

    const PROZENT_SKALA_GENAUIGKEIT = 100 * (10 ** Prozentzahl::NACHKOMMASTELLEN); // 4 Nachkommastellen = 2 Nachkommastellen der
    // Prozentzahl

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return "BIGINT SIGNED";
    }

    /** @return Wertung */
    public function convertToPHPValue($value, AbstractPlatform $platform) {
        if (!$value) {
            return NULL;
        }
        $wertunsTyp = ($value) % self::TYP_FAKTOR;
        $wertungsWert = (int) (($value) / self::TYP_FAKTOR);

        switch ($wertunsTyp) {
            case self::PUNKT_WERTUNG:
                $maxPunktzahl = Punktzahl::fromFloat(
                    ($wertungsWert % self::PUNKT_SKALA_FAKTOR) / self::PUNKT_SKALA_GENAUIGKEIT
                );
                $punktzahl = Punktzahl::fromFloat(
                    ((int) ($wertungsWert / self::PUNKT_SKALA_FAKTOR)) / self::PUNKT_SKALA_GENAUIGKEIT
                );

                $punktSkala = PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat($maxPunktzahl->getValue()));

                return PunktWertung::fromPunktzahlUndSkala($punktzahl, $punktSkala);
                break;
            case self::PROZENT_WERTUNG:
                $prozentZahl = Prozentzahl::fromFloat($wertungsWert / self::PROZENT_SKALA_GENAUIGKEIT);
                return ProzentWertung::fromProzentzahl($prozentZahl);
                break;
            default:
                throw new \Exception("Wertungsart '" . $value % 100 . "'nicht bekannt!'");
        }
    }

    /** @return integer */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        if (!$value instanceof Wertung) {
            throw new \Exception("Wertung muss Interface 'Wertung' implementieren!");
        }
        if ($value instanceof PunktWertung) {
            return (int) (
                self::PUNKT_WERTUNG
                + (self::TYP_FAKTOR * self::PUNKT_SKALA_GENAUIGKEIT *
                    ($value->getSkala()->getMaxPunktzahl()->getValue()))
                + (self::TYP_FAKTOR * self::PUNKT_SKALA_FAKTOR * self::PUNKT_SKALA_GENAUIGKEIT
                    * ($value->getPunktzahl()->getValue()))
            );
        } elseif ($value instanceof ProzentWertung) {
            return self::PROZENT_WERTUNG
                + (self::TYP_FAKTOR * self::PROZENT_SKALA_GENAUIGKEIT * $value->getProzentzahl()->getValue());

        }
        throw new \Exception("Wertungs-Typ '" . get_class($value) . "'ist unbekannt!");
    }

    public function getName() {
        return self::TYPE_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return TRUE;
    }
}