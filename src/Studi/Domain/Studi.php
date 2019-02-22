<?php

namespace Studi\Domain;

use Common\Domain\DefaultEntityComparison;

class Studi
{
    /** @var StudiHash */
    private $studiHash;

    /** @var LoginHash|null */
    private $loginHash = NULL;

    use DefaultEntityComparison;

    public static function fromStudiHash(StudiHash $studiHash) {
        $object = new self();
        $object->studiHash = $studiHash;

        return $object;
    }

    public function getStudiHash(): StudiHash {
        return $this->studiHash;
    }

    public function getLoginHash(): ?LoginHash {
        return $this->loginHash;
    }

    public function setLoginHash(LoginHash $loginHash): void {
        $this->loginHash = $loginHash;
    }

    public function removeLoginHash(): void {
        $this->loginHash = NULL;
    }

}