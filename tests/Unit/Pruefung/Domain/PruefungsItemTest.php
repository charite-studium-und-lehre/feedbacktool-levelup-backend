<?php

namespace Tests\Unit\Pruefung\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;

class PruefungsItemTest extends TestCase
{

    public function testCreate() {

        $id = PruefungsItemId::fromString("12345");
        $pruefungsId = PruefungsId::fromString("789");

        $pruefungsItem = PruefungsItem::create($id, $pruefungsId);

        $this->assertEquals("12345", $pruefungsItem->getId());
        $this->assertEquals($pruefungsId, $pruefungsItem->getPruefungsId());
    }

}