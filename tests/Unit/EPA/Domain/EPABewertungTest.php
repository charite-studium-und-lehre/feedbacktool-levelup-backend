<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use PHPUnit\Framework\TestCase;

class EPABewertungTest extends TestCase
{

    public function testFromInt1() {
        $object = EPABewertung::fromValues(0, EPA::fromInt(111));
        $this->assertEquals(0, $object->getBewertungInt());
        $this->assertEquals(EPABewertung::BEWERTUNG_BESCHREIBUNG[0], $object->getBeschreibung());
    }

    public function testFromInt2() {
        $object = EPABewertung::fromValues(5, EPA::fromInt(111));
        $this->assertEquals(5, $object->getBewertungInt());
        $this->assertEquals(EPABewertung::BEWERTUNG_BESCHREIBUNG[5], $object->getBeschreibung());
    }

    public function testFromInt_Falsch() {
        $this->expectExceptionMessage(EPABewertung::INVALID);
        EPABewertung::fromValues(-1, EPA::fromInt(111));
    }

    public function testFromInt_Falsch2() {
        $this->expectExceptionMessage(EPABewertung::INVALID);
        EPABewertung::fromValues(6, EPA::fromInt(111));
    }

    public function testErhoeheStufe() {
        $epa = EPA::fromInt(111);
        $this->assertEquals(1, EPABewertung::fromValues(0, $epa)->erhoeheStufe()->getBewertungInt());
        $this->assertEquals(2, EPABewertung::fromValues(1, $epa)->erhoeheStufe()->getBewertungInt());
        $this->assertEquals(5, EPABewertung::fromValues(5, $epa)->erhoeheStufe()->getBewertungInt());
    }

    public function testVerringereStufe() {
        $epa = EPA::fromInt(111);
        $this->assertEquals(0, EPABewertung::fromValues(0, $epa)->vermindereStufe()->getBewertungInt());
        $this->assertEquals(0, EPABewertung::fromValues(1, $epa)->vermindereStufe()->getBewertungInt());
        $this->assertEquals(4, EPABewertung::fromValues(5, $epa)->vermindereStufe()->getBewertungInt());
    }

}