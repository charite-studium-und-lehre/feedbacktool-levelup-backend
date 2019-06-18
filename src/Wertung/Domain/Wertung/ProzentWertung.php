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

    public function equals(object $otherObject): bool {
        if (!($otherObject instanceof ProzentWertung)) {
            return FALSE;
        }

        return $this->prozentzahl->equals($otherObject->getProzentzahl());
    }

    /**
     * @return Prozentzahl
     */
    public
    function getProzentzahl(): Prozentzahl {
        return $this->prozentzahl;
    }

}