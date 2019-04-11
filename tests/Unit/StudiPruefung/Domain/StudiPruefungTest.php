<?php

namespace Tests\Unit\StudiPruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsId;
use Studi\Domain\StudiHash;
use StudiPruefung\Domain\StudiPruefung;
use StudiPruefung\Domain\PruefungsItemId;

class StudiPruefungTest extends TestCase
{

    public function testCreate() {

        $id = PruefungsItemId::fromInt("12345");
        $studiHash = StudiHash::fromString(password_hash("test", PASSWORD_ARGON2I));
        $pruefungsId = PruefungsId::fromInt("789");

        $studiPruefung = StudiPruefung::fromValues(
            $id,
            $studiHash,
            $pruefungsId);

        $this->assertEquals("12345", $studiPruefung->getId()->getValue());
        $this->assertEquals($studiHash, $studiPruefung->getStudiHash());
        $this->assertEquals($pruefungsId, $studiPruefung->getPruefungsId());
    }

}