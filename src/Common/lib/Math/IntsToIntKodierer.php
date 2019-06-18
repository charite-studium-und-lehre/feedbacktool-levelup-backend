<?php

namespace Common\lib\Math;

use Assert\Assertion;

/**
 * Kodiert mehrere kleine int-Zahlen in einer großen int-Zahl,
 * Verwendet Modulus und ganzzahlige Division
 */
class IntsToIntKodierer
{
    const MAX_STELLENZAHL = 20;
    /**
     * Verschiebt die Stellen einer Zahl so weit nach Links, dass das Ergebnis verwendet werden kann,
     * um durch Addition mehrere Werte, die versch. Stellen benutzen, zu einer Zahl zu machen
     */
    public static function erzeugeSummand(int $zahlZuKodieren, int $vonStelle, int $bisStelle = self::MAX_STELLENZAHL): int {
        self::checkAssertions($zahlZuKodieren, $vonStelle, $bisStelle);
        $stellenZahl = $bisStelle - $vonStelle + 1;
        Assertion::lessThan($zahlZuKodieren, 10 ** $stellenZahl);

        return (int) (10 ** $vonStelle) * $zahlZuKodieren;
    }

    public static function extrahiereIntAusSumme(int $zahlZuDeKodieren, int $vonStelle, int $bisStelle = self::MAX_STELLENZAHL): int {
        self::checkAssertions($zahlZuDeKodieren, $vonStelle, $bisStelle);
        $zahlAnRichtigerStelle = $zahlZuDeKodieren / (10 ** $vonStelle);

        return $zahlAnRichtigerStelle % (10 ** ($bisStelle - $vonStelle));

    }

    /**
     * @param int $zahlZuKodieren
     * @param int $vonStelle
     * @param int $bisStelle
     */
    private static function checkAssertions(int $zahlZuKodieren, int $vonStelle, int $bisStelle): void {
        Assertion::integerish($zahlZuKodieren);
        Assertion::integerish($vonStelle);
        Assertion::integerish($bisStelle);

        Assertion::lessThan($vonStelle, $bisStelle);
        Assertion::between($vonStelle, 0, self::MAX_STELLENZAHL);
        Assertion::between($bisStelle, 1, self::MAX_STELLENZAHL);
    }

}