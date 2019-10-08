<?php

namespace Tests\Unit\Studi\Domain;

use Common\Domain\User\Nachname;
use PHPUnit\Framework\TestCase;

class NachnameTest extends TestCase
{
    public function testFromString() {
        $value = "Meier-Lüdenscheidt";
        $object = Nachname::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testFromLang() {
        $value = "Frhr.v. Mauchenheim gen. Bechtolshe";
        $object = Nachname::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testFromStringKurz() {
        $value = "Wu";
        $object = Nachname::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function test_FalschLeerzeichen() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Nachname::UNGUELTIG);
        $value = "Müller ";
        Nachname::fromString($value);
    }


    public function test_FalschZuLang() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Nachname::UNGUELTIG_ZU_LANG);
        $value = "Meier-Lüdenscheidt-Müller-Schulze-Lehmann-Schunk-Glöckner";
        \Common\Domain\User\Nachname::fromString($value);
    }

    public function test_FalschZuKurz() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Nachname::UNGUELTIG_ZU_KURZ);
        $value = "A";
        Nachname::fromString($value);
    }
}