<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\SelbstBewertungsTyp;
use PHPUnit\Framework\TestCase;

class SelbstBewertungsTypTest extends TestCase
{

    public function testFromInt() {
        $object = SelbstBewertungsTyp::fromInt(SelbstBewertungsTyp::ZUTRAUEN);
        $this->assertEquals(SelbstBewertungsTyp::ZUTRAUEN, $object->getValue());
    }

    public function testFromInt2() {
        $object = SelbstBewertungsTyp::fromInt(SelbstBewertungsTyp::GEMACHT);
        $this->assertEquals(SelbstBewertungsTyp::GEMACHT, $object->getValue());
    }

    public function testFromInt_Falsch() {
        $this->expectExceptionMessage(SelbstBewertungsTyp::INVALID);
        SelbstBewertungsTyp::fromInt(7);
    }

}