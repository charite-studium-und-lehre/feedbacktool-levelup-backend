<?php

namespace DatenImport\Domain;

use Cluster\Domain\ClusterId;
use Common\Domain\DefaultValueObjectComparison;

class LernzielFach
{
    use DefaultValueObjectComparison;

    /** @var LernzielNummer */
    private $lernzielNummer;

    /** @var ClusterId */
    private $clusterId;

    public static function byIds(LernzielNummer $lernzielNummer, ClusterId $clusterId): self {
        $object = new self();
        $object->lernzielNummer = $lernzielNummer;
        $object->clusterId = $clusterId;

        return $object;
    }

    public function getLernzielNummer(): LernzielNummer {
        return LernzielNummer::fromInt($this->lernzielNummer);
    }

    public function getClusterId(): ClusterId {
        return ClusterId::fromInt($this->clusterId);
    }

}