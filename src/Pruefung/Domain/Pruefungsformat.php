<?php

namespace Cluster\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class ClusterArt
{
    use DefaultValueObjectComparison;

    const FACH_CLUSTER = 10;

    const MODUL_CLUSTER = 20;

    const LERNZIEL_CLUSTER = 30;

    const CLUSTERART_KONSTANTEN = [
        self::FACH_CLUSTER,
        self::MODUL_CLUSTER,
        self::LERNZIEL_CLUSTER,
    ];

    const INVALID_CLUSTERART = "Keine gültige Clusterart: ";

    private $clusterart;

    public static function fromInt(int $clusterart): self {

        Assertion::inArray($clusterart, self::CLUSTERART_KONSTANTEN, self::INVALID_CLUSTERART . $clusterart);

        $object = new self();
        $object->clusterart = $clusterart;

        return $object;
    }

    public function getClusterArt() {
        return $this->clusterart;

    }
}