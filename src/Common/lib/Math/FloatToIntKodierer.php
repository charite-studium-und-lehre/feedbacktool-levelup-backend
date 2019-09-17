<?php

namespace Common\lib\Math;

use Assert\Assertion;

/** Kodiert mehrere kleine int-Zahlen in einer großen int-Zahl,
 * Verwendet Modulus und ganzzahlige Division
 */
class FloatToIntKodierer
{
    const MAX_STELLENZAHL = 20;


    /** Erzeuge aus einer Float-Zahl mit max. Anzahl Nachkommastellen
     * durch Linksschieben der Ziffern eine Int-Zahl
     */
    public static function toInt(float $zahlZuKodieren, int $nachkommastellen): int {
        Assertion::numeric($zahlZuKodieren);
        Assertion::between($zahlZuKodieren, 0, 10 ** self::MAX_STELLENZAHL);
        return (int) ($zahlZuKodieren * (10 ** $nachkommastellen));
    }

    /** Erzeuge aus einer Int-Zahl durch Rechtsschieben der Ziffern eine Float-Zahl */
    public static function fromInt(int $zahlZuDeKodieren, int $nachkommastellen): float {
        Assertion::integerish($zahlZuDeKodieren);
        return ($zahlZuDeKodieren / (10 ** $nachkommastellen));

    }
}