<?php

namespace Studi\Domain;

use Common\Domain\DefaultEntityComparison;
use Common\Domain\User\LoginUser;

class Studi extends LoginUser
{
    private StudiHash $studiHash;

    private ?LoginHash $loginHash = NULL;

    use DefaultEntityComparison;

    public static function fromStudiHash(StudiHash $studiHash): self {
        $object = new self();
        $object->studiHash = $studiHash;

        return $object;
    }

    public function macheZuLoginUser(LoginUser $loginUser): Studi {
        $object = new self();
        $object->studiHash = $this->studiHash;
        $object->loginHash = $this->loginHash;
        $object->vorname = $loginUser->vorname;
        $object->nachname = $loginUser->nachname;
        $object->usernameVO = $loginUser->usernameVO;
        $object->istAdmin = $loginUser->istAdmin;
        $object->email = $loginUser->email;

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

    public function getUsername(): string {
        return parent::getUsername() . "^" . $this->studiHash->getValue();

    }

}