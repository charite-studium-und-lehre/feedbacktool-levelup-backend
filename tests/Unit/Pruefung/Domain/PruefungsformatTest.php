<?php

namespace Tests\Unit\Pruefung\Domain;


use PHPUnit\Framework\TestCase;
use Pruefung\Domain\Pruefungsformat;

class PruefungsformatTest extends TestCase
{



    public function testFromInt() {

        $alleFormate = Pruefungsformat::FORMAT_KONSTANTEN;

        foreach ($alleFormate as $format) {
            $pruefungsformat = Pruefungsformat::fromInt($format);
            $this->assertEquals($format, $pruefungsformat->getFormat());
        }

    }

    public function testFromInt_String() {

        $pruefungsformat = Pruefungsformat::fromInt($format = "" . Pruefungsformat::MC_FORMAT);
        $this->assertEquals($format, $pruefungsformat->getFormat());

    }

    public function testFromInt_FalschesFormat() {

        $format = 123;
        $this->expectExceptionMessage(Pruefungsformat::INVALID_PRUEFUNGSFORMAT . $format);
        Pruefungsformat::fromInt($format);
    }

}