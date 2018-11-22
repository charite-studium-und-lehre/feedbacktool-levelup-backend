<?php

namespace Cluster\Domain;

use Assert\Assertion;


class ClusterTag
{
    /** @var Wertungsitem */
    private $wertungsitem;

    public static function fromString(Wertungsitem $wertungsitem, string $kommentar = NULL): ClusterTag {
        Assertion::nullOrString($kommentar);

        $object = new self();
        $object->wertungsitem = $wertungsitem;
        $object->kommentar = $kommentar;

        return $object;
    }

    /**
     * @see Wertung::getRelativeWertung()
     * @return float
     */
    public function get(): float {
        return $this->prozentzahl->getValue();
    }

    /**
     * @see Wertung::getSkala()
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