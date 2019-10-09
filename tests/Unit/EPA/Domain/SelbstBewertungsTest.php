<?php

namespace Tests\Unit\EPA\Domain;

use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use EPA\Domain\EPABewertungsDatum;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsId;
use EPA\Domain\SelbstBewertungsTyp;
use PHPUnit\Framework\TestCase;
use Studi\Domain\StudiHash;

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
            StudiHash::fromString('$argon2i$v=19$m=1024,t=2,p=2$SjNFNWJPNXVFTkVoaEEwcQ$xrpCKHbfjfjRLrn0K1keYfk6SCFlGQfWuT7edgpaO8E'),
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