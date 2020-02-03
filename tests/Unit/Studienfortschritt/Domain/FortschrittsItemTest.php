<?php

namespace Tests\Unit\Studi\Domain;

use Assert\InvalidArgumentException;
use Exception;
use PHPUnit\Framework\TestCase;
use Studienfortschritt\Domain\FortschrittsItem;
use StudiPruefung\Domain\StudiPruefungsId;

class FortschrittsItemTest extends TestCase
{
    public function testCreateAnwesenheit() {
        $fortschrittsItem = FortschrittsItem::fromCode(101);

        $this->assertEquals(101, $fortschrittsItem->getCode());
        $this->assertEquals("anw_sem1", $fortschrittsItem->getKuerzel());
        $this->assertEquals("Anwesenheit Sem. 1", $fortschrittsItem->getTitel());
        $this->assertEquals(1, $fortschrittsItem->getFachsemester());
        $this->assertEquals([], $fortschrittsItem->getImplizierteFortschrittsItems());
        $this->assertEquals(NULL, $fortschrittsItem->getStudiPruefungsId());
        $this->assertEquals(NULL, $fortschrittsItem->getPruefungsTyp());
    }

    public function testCreatePruefung() {
        $studiPruefungsId = StudiPruefungsId::fromInt(456);
        $fortschrittsItem = FortschrittsItem::fromCode(409, $studiPruefungsId);

        $this->assertEquals(409, $fortschrittsItem->getCode());
        $this->assertEquals("MC-Sem9", $fortschrittsItem->getKuerzel());
        $this->assertEquals("MC-Prüfung Sem. 9", $fortschrittsItem->getTitel());
        $this->assertEquals(9, $fortschrittsItem->getFachsemester());
        $this->assertEquals([], $fortschrittsItem->getImplizierteFortschrittsItems());
        $this->assertEquals($studiPruefungsId, $fortschrittsItem->getStudiPruefungsId());
        $this->assertEquals("mc", $fortschrittsItem->getPruefungsTyp());
    }

    public function testImpliziteMeilensteine() {
        $fortschrittsItem = FortschrittsItem::fromCode(201);

        $this->assertEquals(
            [FortschrittsItem::fromCode(401)],
            $fortschrittsItem->getImplizierteFortschrittsItems()
        );
    }

    public function testFalsch_ungueltigerCode() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(FortschrittsItem::UNGUELTIG);
        FortschrittsItem::fromCode(150);
    }

    public function testFalsch_PruefungsIdBeiMeilenstein() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Ein Meilenstein kann keinen Bezug zu einer Prüfung haben");
        FortschrittsItem::fromCode(10, StudiPruefungsId::fromInt(456));
    }
}