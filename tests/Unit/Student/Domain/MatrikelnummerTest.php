<?php

namespace Tests\Unit\Student\Domain;


use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Student\Domain\Matrikelnummer;

class MatrikelnummerTest extends TestCase
{
    public function testFromInt() {
        $value = 123456;
        $object = Matrikelnummer::fromInt($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testFromInt_FalschZuKlein() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Matrikelnummer::INVALID_STELLEN);
        Matrikelnummer::fromInt(12345);
    }

    public function testFromInt_FalschZuGross() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Matrikelnummer::INVALID_STELLEN);
        Matrikelnummer::fromInt(1234567);
    }

    public function testFromInt_FalschString() {
        $this->expectException(InvalidArgumentException::class);
        Matrikelnummer::fromInt("123456ab");
    }

    public function testFromInt_FalschString2() {
        $this->expectException(InvalidArgumentException::class);
        Matrikelnummer::fromInt("123456.2");
    }
}