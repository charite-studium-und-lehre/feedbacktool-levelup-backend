<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\EPAKategorie;
use PHPUnit\Framework\TestCase;

class EPAKategorieTest extends TestCase
{

    public function testFromInt() {
        $object = EPAKategorie::fromInt(110);
        $this->assertEquals(110, $object->getValue());
        $this->assertEquals(100, $object->getParent()->getValue());
        $this->assertStringContainsString("Anamnese erheben", $object->getBeschreibung());
    }

    public function testFromInt2() {
        $object = EPAKategorie::fromInt(200);
        $this->assertEquals(200, $object->getValue());
        $this->assertNull($object->getParent());
        $this->assertStringContainsString("Ärztliche Prozeduren", $object->getBeschreibung());
    }

    public function testFromInt_Falsch() {
        $this->expectExceptionMessage(EPAKategorie::INVALID);
        EPAKategorie::fromInt(7);
    }

    public function testGetEPASTruktur() {
        $struktur = EPAKategorie::getEPAStruktur();

        $this->assertEquals(111, $struktur[100][110][111]->getValue());
        $this->assertEquals(201, $struktur[200][201]->getValue());
    }

}