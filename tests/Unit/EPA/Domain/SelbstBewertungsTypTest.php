<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\SelbstBewertung\SelbstBewertungsTyp;
use PHPUnit\Framework\TestCase;

class SelbstBewertungsTypTest extends TestCase
{

    public function testFromInt() {
        $object = \EPA\Domain\SelbstBewertung\SelbstBewertungsTyp::fromInt(SelbstBewertungsTyp::ZUTRAUEN);
        $this->assertEquals(\EPA\Domain\SelbstBewertung\SelbstBewertungsTyp::ZUTRAUEN, $object->getValue());
    }

    public function testFromInt2() {
        $object = SelbstBewertungsTyp::fromInt(SelbstBewertungsTyp::GEMACHT);
        $this->assertEquals(\EPA\Domain\SelbstBewertung\SelbstBewertungsTyp::GEMACHT, $object->getValue());
    }

    public function testFromInt_Falsch() {
        $this->expectExceptionMessage(\EPA\Domain\SelbstBewertung\SelbstBewertungsTyp::INVALID);
        \EPA\Domain\SelbstBewertung\SelbstBewertungsTyp::fromInt(7);
    }

}