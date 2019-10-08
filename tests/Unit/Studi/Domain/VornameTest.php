<?php

namespace Tests\Unit\Studi\Domain;

use Common\Domain\User\Vorname;
use PHPUnit\Framework\TestCase;

class VornameTest extends TestCase
{
    public function testFromString() {
        $value = "Ulla";
        $object = Vorname::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testFromStringDoppelname() {
        $value = "Hans Peter";
        $object = Vorname::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testFromStringDoppelnameBindestrich() {
        $value = "Hans-Peter";
        $object = Vorname::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }


    public function test_FalschLeerzeichen() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Vorname::UNGUELTIG);
        $value = " Hans Peter";
        Vorname::fromString($value);
    }

    public function test_FalschZuLang() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Vorname::UNGUELTIG_ZU_LANG);
        $value = "Pippilotta Viktualia Rollgardina Pfefferminz Efraimstochter";
        Vorname::fromString($value);
    }

    public function test_FalschZuKurz() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Vorname::UNGUELTIG_ZU_KURZ);
        $value = "A";
        Vorname::fromString($value);
    }
}