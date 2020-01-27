<?php

namespace Studi\Domain;

use Common\Domain\DefaultEntityComparison;

class StudiIntern
{
    private StudiHash $studiHash;

    private Matrikelnummer $matrikelnummer;

    use DefaultEntityComparison;

    public static function fromMatrikelUndStudiHash(Matrikelnummer $matrikelnummer, StudiHash $studiHash) {
        $object = new self();
        $object->matrikelnummer = $matrikelnummer;
        $object->studiHash = $studiHash;

        return $object;
    }

    public function getStudiHash(): StudiHash {
        return $this->studiHash;
    }

    public function getMatrikelnummer(): Matrikelnummer {
        return $this->matrikelnummer;
    }

}