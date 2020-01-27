<?php

namespace Studienfortschritt\Domain;

use Common\Domain\DefaultEntityComparison;
use Studi\Domain\StudiHash;

class StudiMeilenstein
{
    use DefaultEntityComparison;

    private StudiMeilensteinId $id;

    private StudiHash $studiHash;

    private FortschrittsItem $meilenstein;

    public static function fromValues(
        StudiMeilensteinId $id,
        StudiHash $studiHash,
        FortschrittsItem $meilenstein
    ): self {
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