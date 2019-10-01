<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\EPA;
use PHPUnit\Framework\TestCase;

class EPATest extends TestCase
{

    public function testFromInt() {
        $object = EPA::fromInt(111);
        $this->assertEquals(111, $object->getValue());
        $this->assertEquals(110, $object->getParent()->getValue());
        $this->assertStringContainsString("Anamnese erheben", $object->getBeschreibung());
    }

    public function testFromInt2() {
        $object = EPA::fromInt(201);
        $this->assertEquals(201, $object->getValue());
        $this->assertEquals(200, $object->getParent()->getValue());
        $this->assertStringContainsString("Blut entnehmen", $object->getBeschreibung());
    }

    public function testFromInt_Falsch() {
        $this->expectExceptionMessage(EPA::INVALID);
        EPA::fromInt(7);
    }

}