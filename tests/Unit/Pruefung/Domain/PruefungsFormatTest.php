<?php

namespace Tests\Unit\Pruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsFormat;

class PruefungsFormatTest extends TestCase
{

    public function testFromInt() {

        $alleFormate = PruefungsFormat::FORMAT_KONSTANTEN;

        foreach ($alleFormate as $format) {
            $pruefungsformat = PruefungsFormat::fromConst($format);
            $this->assertEquals($format, $pruefungsformat->getValue());
        }

    }

    public function testFromInt_String() {
        $pruefungsformat = PruefungsFormat::fromConst($format = " " . PruefungsFormat::MC);
        $this->assertEquals($format, $pruefungsformat->getValue());
    }

    public function testGetTitel() {

        $pruefungsformat = PruefungsFormat::fromConst(PruefungsFormat::MC);
        $this->assertEquals(PruefungsFormat::FORMAT_TITEL[PruefungsFormat::MC],
                            $pruefungsformat->getTitel()
        );

    }

    public function testFromInt_FalschesFormat() {

        $format = 123;
        $this->expectExceptionMessage(PruefungsFormat::INVALID_PRUEFUNGSFORMAT . $format);
        PruefungsFormat::fromConst($format);
    }

}