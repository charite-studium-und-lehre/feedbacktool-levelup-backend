<?php

namespace Tests\Unit\StudiPruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\StudiPruefungsId;

class StudiPruefungTest extends TestCase
{

    public function testCreate() {

        $id = StudiPruefungsId::fromInt("12345");
        $studiHash = StudiHash::fromString(hash("sha256","test"));
        $pruefungsId = PruefungsId::fromString("789");

        $studiPruefung = StudiPruefung::fromValues(
            $id,
            $studiHash,
            $pruefungsId);

        $this->assertEquals("12345", $studiPruefung->getId()->getValue());
        $this->assertEquals($studiHash, $studiPruefung->getStudiHash());
        $this->assertEquals($pruefungsId, $studiPruefung->getPruefungsId());
    }

}