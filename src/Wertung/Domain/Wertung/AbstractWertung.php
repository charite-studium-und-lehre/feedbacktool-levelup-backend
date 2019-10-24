<?php

namespace Wertung\Domain\Wertung;

use Common\Domain\DefaultValueObjectComparison;

abstract class AbstractWertung implements Wertung
{
    use DefaultValueObjectComparison;

    public function istPunktWertung(): bool {
        return $this instanceof PunktWertung;
    }

    public function getPunktWertung(): PunktWertung {
        if ($this->istPunktWertung()) {
            return $this;
        }
        throw new \Exception("Ist keine Punktwertung!");
    }

    public function istProzentWertung(): bool {
        return $this instanceof ProzentWertung;
    }

    public function getProzentWertung(): ProzentWertung {
        if ($this->istProzentWertung()) {
            return $this;
        }
        throw new \Exception("Ist keine Prozentwertung!");
    }

    public function istRichtigFalschWeissnichtWertung(): bool {
        return $this instanceof RichtigFalschWeissnichtWertung;
    }

    public function getRichtigFalschWeissnichtWertung(): RichtigFalschWeissnichtWertung {
        if ($this->istRichtigFalschWeissnichtWertung()) {
            return $this;
        }
        throw new \Exception("Ist keine RichtigFalschWeissnichtWertung!");
    }

    /**
     * @param float[] $zahlen
     */
    protected static function getDurchschnittAusZahlen(array $zahlen): float {
        return array_sum ($zahlen) / count($zahlen);
    }

    /**
     * @param float[] $zahlen
     */
    protected static function getSummeAusZahlen(array $zahlen): float {
        return array_sum ($zahlen);
    }

}