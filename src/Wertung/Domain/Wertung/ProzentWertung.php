<?php

namespace Wertung\Domain\Wertung;

use Assert\Assertion;
use Wertung\Domain\Skala\ProzentSkala;
use Wertung\Domain\Skala\Skala;

class ProzentWertung extends AbstractWertung
{
    /** @var Prozentzahl */
    private $prozentzahl;

    public static function fromProzentzahl(Prozentzahl $prozentzahl, string $kommentar = NULL): ProzentWertung {
        Assertion::nullOrString($kommentar);

        $object = new self();
        $object->prozentzahl = $prozentzahl;
        $object->kommentar = $kommentar;

        return $object;
    }

    /**
     * @see WertungsInterface::getRelativeWertung()
     * @return float
     */
    public function getRelativeWertung(): float {
        return $this->prozentzahl->getValue();
    }

    /**
     * @see WertungsInterface::getSkala()
     * @return Skala
     */
    public function getSkala(): Skala {
        return ProzentSkala::create();
    }

    /**
     * @return Prozentzahl
     */
    public function getProzentzahl(): Prozentzahl {
        return $this->prozentzahl;
    }

}