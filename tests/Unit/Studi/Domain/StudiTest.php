<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Studi\Domain\LoginHash;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;

class StudiTest extends TestCase
{
    public function testCreate() {
        $pwHash = StudiHash::fromString(hash("sha256","test"));
        $studi = Studi::fromStudiHash($pwHash);
        $this->assertEquals($pwHash, $studi->getStudiHash());
        $this->assertEquals(NULL, $studi->getLoginHash());
    }

    public function testLoginHash() {
        $pwHash = StudiHash::fromString(hash("sha256","test",));
        $studi = Studi::fromStudiHash($pwHash);
        $this->assertEquals(NULL, $studi->getLoginHash());

        $loginHash = LoginHash::fromString(hash("sha256","test2"));
        $studi->setLoginHash($loginHash);
        $this->assertEquals($loginHash, $studi->getLoginHash());

        $studi->removeLoginHash($loginHash);
        $this->assertEquals(NULL, $studi->getLoginHash());

    }
}