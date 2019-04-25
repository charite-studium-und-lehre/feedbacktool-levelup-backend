<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Studi\Domain\Geburtsdatum;

class GeburtsDatumTest extends TestCase
{
    public function testFromStringDeutsch() {
        $value = "10.12.2000";
        $object = Geburtsdatum::fromStringDeutsch($value);

        $this->assertEquals($value, $object->getValue()->format("d.m.Y"));
    }

    public function testFromStringDeutschMinus() {
        $value = "10-12-2000";
        $object = Geburtsdatum::fromStringDeutschMinus($value);

        $this->assertEquals($value, $object->getValue()->format("d-m-Y"));
    }

    public function testFromDateTimeImmutable() {
        $value = "10/12/2000";
        $object = Geburtsdatum::fromDateTimeImmutable(
            \DateTimeImmutable::createFromFormat("d/m/Y", $value));

        $this->assertEquals($value, $object->getValue()->format("d/m/Y"));
    }

    public function test_FalschesFormat() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Geburtsdatum::UNGUELTIG);
        $value = "1999-10-20";
        $object = Geburtsdatum::fromStringDeutsch($value);

        $this->assertEquals($value, $object->getValue()->format("d.m.Y"));
    }

    public function test_FalschZuAlt() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Geburtsdatum::UNGUELTIG_JAHR);
        $value = "10.12.1930";
        $object = Geburtsdatum::fromStringDeutsch($value);

        $this->assertEquals($value, $object->getValue()->format("d.m.Y"));
    }


    public function test_ZuJung() {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Geburtsdatum::UNGUELTIG_JAHR);
        $value = "10.12.2120";
        $object = Geburtsdatum::fromStringDeutsch($value);

        $this->assertEquals($value, $object->getValue()->format("d.m.Y"));
    }


}