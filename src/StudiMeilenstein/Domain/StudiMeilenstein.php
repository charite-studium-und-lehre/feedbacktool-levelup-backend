<?php

namespace StudiMeilenstein\Domain;

use Common\Domain\DefaultEntityComparison;
use Studi\Domain\StudiHash;

class StudiMeilenstein
{
    use DefaultEntityComparison;

    /** @var StudiMeilensteinId */
    private $id;

    /** @var StudiHash */
    private $studiHash;

    /** @var Meilenstein */
    private $meilenstein;

    public static function fromValues(StudiMeilensteinId $id, StudiHash $studiHash, Meilenstein $meilenstein) {
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

    public function getMeilenstein(): Meilenstein {
        return $this->meilenstein;
    }

}