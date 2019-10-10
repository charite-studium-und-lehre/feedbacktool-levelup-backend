<?php

namespace Studienfortschritt\Domain;

use Common\Domain\DefaultEntityComparison;
use Studi\Domain\StudiHash;

class StudiMeilenstein
{
    use DefaultEntityComparison;

    /** @var StudiMeilensteinId */
    private $id;

    /** @var StudiHash */
    private $studiHash;

    /** @var FortschrittsItem */
    private $meilenstein;

    public static function fromValues(StudiMeilensteinId $id, StudiHash $studiHash, FortschrittsItem $meilenstein) {
        $object = new self();
        $object->id = $id;
        $object->studiHash = $studiHash;
        $object->meilenstein = $meilenstein;

        return $object;
    }

    public function getId(): StudiMeilensteinId {
        return StudiMeilensteinId::fromInt($this->id->getValue());
    }

    public function getStudiHash(): StudiHash {
        return $this->studiHash;
    }

    public function getMeilenstein(): FortschrittsItem {
        return $this->meilenstein;
    }

}