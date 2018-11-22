<?php

namespace Tests\Unit\Pruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungId;
use Pruefung\Domain\Pruefungsformat;

class PruefungTest extends TestCase
{

    public function testCreate(){

        $id = PruefungId::fromInt("12345");
        $pruefungsformat = Pruefungsformat::fromInt(Pruefungsformat::MC_FORMAT);

        $pruefung = Pruefung::create($id, $pruefungsformat);

        $this->assertEquals("12345", $pruefung->getId());
        $this->assertEquals(Pruefungsformat::MC_FORMAT, $pruefung->getPruefungsFormat()->getFormat());
    }





}