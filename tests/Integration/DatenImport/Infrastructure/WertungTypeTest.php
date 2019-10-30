<?php

namespace Tests\Integration\DatenImport\Infrastructure\Persistence;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use PHPUnit\Framework\TestCase;
use Wertung\Infrastructure\Persistence\DB\DoctrineTypes\WertungType;

final class WertungTypeTest extends TestCase
{

    public function testRichtigFalschWeissnicht() {

        $this->assertRichtigFalschWeissnicht(1292346, 346, 292, 1);
        $this->assertRichtigFalschWeissnicht(774873, 873, 774, 0);
    }

    private function assertRichtigFalschWeissnicht(
        int $zahlkodiert,
        int $zahlRichtig,
        int $zahlFalsch,
        int $zahlWeissnicht
    ) {
        $this->assertEquals($zahlRichtig,
                            WertungType::dekodiereRichtigFalschWeissnichtWertung($zahlkodiert, new MySqlPlatform())
                                ->getRichtigFalschWeissnichtWertung()
                                ->getPunktzahlRichtig()->getValue());
        $this->assertEquals($zahlFalsch,
                            WertungType::dekodiereRichtigFalschWeissnichtWertung($zahlkodiert, new MySqlPlatform())
                                ->getRichtigFalschWeissnichtWertung()
                                ->getPunktzahlFalsch()->getValue());
        $this->assertEquals($zahlWeissnicht,
                            WertungType::dekodiereRichtigFalschWeissnichtWertung($zahlkodiert, new MySqlPlatform())
                                ->getRichtigFalschWeissnichtWertung()
                                ->getPunktzahlWeissnicht()->getValue());
    }
}
