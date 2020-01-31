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
        FortschrittsItem $fortschrittsItem
    ): self {
        $object = new self();
        $object->id = $id;
        $object->studiHash = $studiHash;
        $object->meilenstein = $fortschrittsItem;

        return $object;
    }

    public function getId(): StudiMeilensteinId {
        return $this->id;
    }

    public function getStudiHash(): StudiHash {
        return $this->studiHash;
    }

    public function getFortschrittsItem(): FortschrittsItem {
        return $this->meilenstein;
    }

}