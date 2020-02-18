<?php

namespace Studi\Infrastructure\Service;

use Common\Domain\User\Username;
use Studi\Domain\LoginHash;
use Studi\Domain\Service\LoginHashCreator;

class LoginHashCreator_SHA256 extends AbstractHashCreator implements LoginHashCreator
{
    public function createLoginHash(Username $username): LoginHash {
        return LoginHash::fromString(
            $this->createHash($username->getValue())
        );
    }

    public function isCorrectLoginHash(LoginHash $loginHash, Username $username): bool {
        return $this->verifyHash($username->getValue(), $loginHash->getValue());
    }

}