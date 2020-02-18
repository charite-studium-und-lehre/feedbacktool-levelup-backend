<?php

namespace Wertung\Domain\Wertung;

use Common\Domain\DefaultValueObjectComparison;
use Exception;

abstract class AbstractWertung implements Wertung
{
    use DefaultValueObjectComparison;

    /**
     * @param float[] $zahlen
     */
    protected static function getDurchschnittAusZahlen(array $zahlen): float {
        return array_sum($zahlen) / count($zahlen);
    }

    /**
     * @param float[] $zahlen
     */
    protected static function getSummeAusZahlen(array $zahlen): float {
        return array_sum($zahlen);
    }

    public function getPunktWertung(): PunktWertung {
        if ($this instanceof PunktWertung) {
            return $this;
        }
        throw new Exception("Ist keine Punktwertung!");
    }

    public function getProzentWertung(): ProzentWertung {
        if ($this instanceof ProzentWertung) {
            return $this;
        }
        throw new Exception("Ist keine Prozentwertung!");
    }

    public function getRichtigFalschWeissnichtWertung(): RichtigFalschWeissnichtWertung {
        if ($this instanceof RichtigFalschWeissnichtWertung) {
            return $this;
        }
        throw new Exception("Ist keine RichtigFalschWeissnichtWertung!");
    }

}