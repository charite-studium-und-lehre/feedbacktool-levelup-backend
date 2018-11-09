<?php

namespace Tests\Unit\Studi\Domain;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Studi\Domain\Email;

class EmailTest extends TestCase
{
    public function testFromString() {
        $value = "a@b.de";
        $object = Email::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testFromString_Lang() {
        $value = "marius-mueller-westernhagen@hoeren.de";
        $object = Email::fromString($value);

        $this->assertEquals($value, $object->getValue());
    }

    public function testFromString_FalschSonderzeichen() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Email::UNGUELTIG);

        Email::fromString("marius-müller-westernhagen@hören.de");
    }

    public function testFromString_FalschKeineDomain() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Email::UNGUELTIG);
        Email::fromString("a@");
    }

    public function testFromString_FalschKeineDomain2() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Email::UNGUELTIG);
        Email::fromString("a");
    }

    public function testFromString_FalschKeineDomain3() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Email::UNGUELTIG);
        Email::fromString("a@b");
    }
}