<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use PHPUnit\Framework\TestCase;

class EPABewertungTest extends TestCase
{

    public function testFromInt1() {
        $object = EPABewertung::fromValues(0, EPA::fromInt(111));
        $this->assertEquals(0, $object->getBewertung());
        $this->assertEquals(EPABewertung::BEWERTUNG_BESCHREIBUNG[0], $object->getBeschreibung());
    }

    public function testFromInt2() {
        $object = EPABewertung::fromValues(5, EPA::fromInt(111));
        $this->assertEquals(5, $object->getBewertung());
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
        $this->assertEquals(1, EPABewertung::fromValues(0, $epa)->erhoeheStufe()->getBewertung());
        $this->assertEquals(2, EPABewertung::fromValues(1, $epa)->erhoeheStufe()->getBewertung());
        $this->assertEquals(5, EPABewertung::fromValues(5, $epa)->erhoeheStufe()->getBewertung());
    }

    public function testVerringereStufe() {
        $epa = EPA::fromInt(111);
        $this->assertEquals(0, EPABewertung::fromValues(0, $epa)->vermindereStufe()->getBewertung());
        $this->assertEquals(0, EPABewertung::fromValues(1, $epa)->vermindereStufe()->getBewertung());
        $this->assertEquals(4, EPABewertung::fromValues(5, $epa)->vermindereStufe()->getBewertung());
    }

}