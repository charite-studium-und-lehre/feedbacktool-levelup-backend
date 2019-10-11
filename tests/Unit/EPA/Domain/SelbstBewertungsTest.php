<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use EPA\Domain\EPABewertungsDatum;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsId;
use EPA\Domain\SelbstBewertungsTyp;
use PHPUnit\Framework\TestCase;
use Studi\Domain\LoginHash;

class SelbstBewertungsTest extends TestCase
{

    public static function setzeDatumMitReflectionAuf(
        SelbstBewertung $selbstBewertung,
        EPABewertungsDatum $bewertungsDatum
    ) {
        $refObject = new \ReflectionObject($selbstBewertung);
        $refProperty = $refObject->getProperty('epaBewertungsDatum');
        $refProperty->setAccessible(TRUE);
        $refProperty->setValue($selbstBewertung, $bewertungsDatum);

    }

    public function testCreate() {
        $object = SelbstBewertung::create(
            SelbstBewertungsId::fromInt(123),
            LoginHash::fromString('a008dbcd86fa8d0738e1f6e0738e1f6e0f50f5daefe9fd2a7a9dddcace0062a0'),
            EPABewertung::fromValues(3, EPA::fromInt(111)),
            SelbstBewertungsTyp::getZutrauenObject()
        );
        $this->assertEquals(SelbstBewertungsTyp::getZutrauenObject(), $object->getSelbstBewertungsTyp());
        $this->assertTrue($object->getEpaBewertungsDatum()->equals(EPABewertungsDatum::heute()));

        return $object;
    }

    public function testAktualisiereDatumBeiErhoehung() {
        $object = $this->testCreate();

        $this->setzeDatumMitReflectionAuf(
            $object,
            EPABewertungsDatum::fromString("10.09.2016")
        );
        $this->assertFalse($object->getEpaBewertungsDatum()->equals(EPABewertungsDatum::heute()));
        $object->erhoeheBewertung();
        $this->assertTrue($object->getEpaBewertung()->equals(
            EPABewertung::fromValues(4, EPA::fromInt(111)))
        );
        $this->assertTrue($object->getEpaBewertungsDatum()->equals(EPABewertungsDatum::heute()));
    }

    public function testFromInt_Falsch() {
        $this->expectExceptionMessage(SelbstBewertungsTyp::INVALID);
        SelbstBewertungsTyp::fromInt(7);
    }

}