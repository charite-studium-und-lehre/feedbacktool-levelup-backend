<?php

namespace Wertung\Domain\Wertung;

use Wertung\Domain\Skala\ProzentSkala;
use Wertung\Domain\Skala\Skala;

class ProzentWertung extends AbstractWertung
{
    /** @var Prozentzahl */
    private $prozentzahl;

    public static function fromProzentzahl(Prozentzahl $prozentzahl): self {

        $object = new self();
        $object->prozentzahl = $prozentzahl;

        return $object;
    }

    /**
     * @return float
     * @see Wertung::getRelativeWertung()
     */
    public function getRelativeWertung(): float {
        return $this->prozentzahl->getValue();
    }

    /**
     * @return Skala
     * @see Wertung::getSkala()
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

    public function equals(object $otherObject): bool {
        return $this->prozentzahl->equals($otherObject->getProzentWert());
    }

}