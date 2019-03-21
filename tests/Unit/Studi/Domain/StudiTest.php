<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Studi\Domain\LoginHash;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;

class StudiTest extends TestCase
{
    public function testCreate() {
        $pwHash = StudiHash::fromString(password_hash("test", PASSWORD_ARGON2I));
        $studi = Studi::fromStudiHash($pwHash);
        $this->assertEquals($pwHash, $studi->getStudiHash());
        $this->assertEquals(NULL, $studi->getLoginHash());
    }

    public function testLoginHash() {
        $pwHash = StudiHash::fromString(password_hash("test", PASSWORD_ARGON2I));
        $studi = Studi::fromStudiHash($pwHash);
        $this->assertEquals(NULL, $studi->getLoginHash());

        $loginHash = LoginHash::fromString(password_hash("test2", PASSWORD_ARGON2I));
        $studi->setLoginHash($loginHash);
        $this->assertEquals($loginHash, $studi->getLoginHash());

        $studi->removeLoginHash($loginHash);
        $this->assertEquals(NULL, $studi->getLoginHash());

    }
}