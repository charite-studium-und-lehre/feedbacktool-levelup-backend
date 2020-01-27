<?php

namespace DatenImport\Domain;

use Cluster\Domain\ClusterId;
use Common\Domain\DefaultValueObjectComparison;

class LernzielFach
{
    use DefaultValueObjectComparison;

    private LernzielNummer $lernzielNummer;

    private ClusterId $clusterId;

    public static function byIds(LernzielNummer $lernzielNummer, ClusterId $clusterId): self {
        $object = new self();
        $object->lernzielNummer = $lernzielNummer;
        $object->clusterId = $clusterId;

        return $object;
    }

    public function getLernzielNummer(): LernzielNummer {
        return $this->lernzielNummer;
    }

    public function getClusterId(): ClusterId {
        return $this->clusterId;
    }

}