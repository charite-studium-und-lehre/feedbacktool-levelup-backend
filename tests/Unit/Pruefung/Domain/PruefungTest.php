<?php

namespace Tests\Unit\Pruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsDatum;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsFormat;

class PruefungTest extends TestCase
{

    public function testCreate(){

        $id = PruefungsId::fromString("12345");
        $pruefungsFormat = PruefungsFormat::fromConst(PruefungsFormat::MC);
        $pruefungsDatum = PruefungsDatum::fromString("20.08.2018");

        $pruefung = Pruefung::create($id, $pruefungsDatum, $pruefungsFormat);

        $this->assertEquals("12345", $pruefung->getId()->getValue());
        $this->assertEquals($pruefungsDatum, $pruefung->getDatum());
        $this->assertEquals(PruefungsFormat::MC, $pruefung->getFormat()->getValue());
    }





}