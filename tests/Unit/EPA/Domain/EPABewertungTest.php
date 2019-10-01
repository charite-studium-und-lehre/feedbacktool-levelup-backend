<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\EPABewertung;
use PHPUnit\Framework\TestCase;

class EPABewertungTest extends TestCase
{

    public function testFromInt1() {
        $object = EPABewertung::fromInt(0);
        $this->assertEquals(0, $object->getBewertung());
        $this->assertEquals(EPABewertung::BEWERTUNG_BESCHREIBUNG[0], $object->getBeschreibung());
    }

    public function testFromInt2() {
        $object = EPABewertung::fromInt(5);
        $this->assertEquals(5, $object->getBewertung());
        $this->assertEquals(EPABewertung::BEWERTUNG_BESCHREIBUNG[5], $object->getBeschreibung());
    }

    public function testFromInt_Falsch() {
        $this->expectExceptionMessage(EPABewertung::INVALID);
        EPABewertung::fromInt(-1);
    }

    public function testFromInt_Falsch2() {
        $this->expectExceptionMessage(EPABewertung::INVALID);
        EPABewertung::fromInt(6);
    }

    public function testErhoeheStufe() {
        $this->assertEquals(1, EPABewertung::fromInt(0)->erhoeheStufe()->getBewertung());
        $this->assertEquals(2, EPABewertung::fromInt(1)->erhoeheStufe()->getBewertung());
        $this->assertEquals(5, EPABewertung::fromInt(5)->erhoeheStufe()->getBewertung());
    }

    public function testVerringereStufe() {
        $this->assertEquals(0, EPABewertung::fromInt(0)->vermindereStufe()->getBewertung());
        $this->assertEquals(0, EPABewertung::fromInt(1)->vermindereStufe()->getBewertung());
        $this->assertEquals(4, EPABewertung::fromInt(5)->vermindereStufe()->getBewertung());
    }

}