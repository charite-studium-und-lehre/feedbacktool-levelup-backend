<?php

namespace Tests\Unit\Studi\Domain;

use PHPUnit\Framework\TestCase;
use Pruefung\Domain\PruefungsItemId;
use Studi\Domain\LoginHash;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\StudiMeilenstein;
use Studienfortschritt\Domain\StudiMeilensteinId;

class StudiMeilensteinTest extends TestCase
{
    public function testCreate() {
        $id = StudiMeilensteinId::fromInt(123);
        $studiHash = StudiHash::fromString("o976tzghj876tgfbhnjki8u765trfghjkio98765tghjkio9876zthjklop0987z6hjk");
        $fortschrittsItem = FortschrittsItem::fromCode(101);

        $studiMeilenstein = StudiMeilenstein::fromValues($id,$studiHash, $fortschrittsItem);

        $this->assertEquals($studiMeilenstein->getId(), $id);
        $this->assertEquals($studiMeilenstein->getStudiHash(), $studiHash);
        $this->assertEquals($studiMeilenstein->getFortschrittsItem(), $fortschrittsItem);
    }
}