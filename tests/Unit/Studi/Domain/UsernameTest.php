<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Studi\Domain\Username;

class UsernameTest extends TestCase
{
    public function testFromString() {
        $value = "dittmarm";
        $object = Username::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testLowercase() {
        $value = "DiTtMaRm";
        $object = Username::fromString($value);

        $this->assertEquals("dittmarm", $object->getValue());
    }

    public function test_FalschUngueltigeZeichen() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::UNGUELTIG);
        $value = "dittma?";
        Username::fromString($value);
    }

    public function test_FalschZuLang() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::UNGUELTIG);
        $value = "dittmarma";
        Username::fromString($value);
    }

    public function test_FalschZuKurz() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Username::UNGUELTIG);
        $value = "di";
        Username::fromString($value);
    }
}