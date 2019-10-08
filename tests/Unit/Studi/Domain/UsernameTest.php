<?php

namespace Tests\Unit\Studi\Domain;

use Common\Domain\User\Username;
use PHPUnit\Framework\TestCase;

class UsernameTest extends TestCase
{
    public function testFromString() {
        $value = "dittmarm";
        $object = \Common\Domain\User\Username::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testLowercase() {
        $value = "DiTtMaRm";
        $object = \Common\Domain\User\Username::fromString($value);

        $this->assertEquals("dittmarm", $object->getValue());
    }

    public function test_FalschUngueltigeZeichen() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::UNGUELTIG);
        $value = "dittma?";
        \Common\Domain\User\Username::fromString($value);
    }

    public function test_FalschZuLang() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\Common\Domain\User\Username::UNGUELTIG);
        $value = "dittmarma";
        \Common\Domain\User\Username::fromString($value);
    }

    public function test_FalschZuKurz() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\Common\Domain\User\Username::UNGUELTIG);
        $value = "di";
        \Common\Domain\User\Username::fromString($value);
    }
}