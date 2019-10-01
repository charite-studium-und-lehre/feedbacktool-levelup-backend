<?php

namespace Tests\Unit\Pruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsPeriode;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsFormat;

class PruefungTest extends TestCase
{

    public function testCreate(){

        $id = PruefungsId::fromString("12345");
        $pruefungsFormat = PruefungsFormat::fromConst(PruefungsFormat::MC_SEM2);
        $pruefungsPeriode = PruefungsPeriode::fromInt(201811);

        $pruefung = Pruefung::create($id, $pruefungsPeriode, $pruefungsFormat);

        $this->assertEquals("12345", $pruefung->getId()->getValue());
        $this->assertEquals($pruefungsPeriode, $pruefung->getPruefungsPeriode());
        $this->assertEquals(PruefungsFormat::MC_SEM2, $pruefung->getFormat()->getValue());
    }





}