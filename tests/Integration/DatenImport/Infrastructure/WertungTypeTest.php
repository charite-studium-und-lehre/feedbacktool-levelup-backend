<?php

namespace Tests\Integration\DatenImport\Infrastructure\Persistence;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use PHPUnit\Framework\TestCase;
use Wertung\Infrastructure\Persistence\DB\DoctrineTypes\WertungType;

final class WertungTypeTest extends TestCase
{

    public function testRichtigFalschWeissnicht() {

        $this->assertRichtigFalschWeissnicht(129234603, 346, 292, 1);
        $this->assertRichtigFalschWeissnicht(77487303, 873, 774, 0);
    }

    private function assertRichtigFalschWeissnicht(
        int $zahlkodiert,
        int $zahlRichtig,
        int $zahlFalsch,
        int $zahlWeissnicht
    ) {
        $wertungType = new WertungType();
        $this->assertEquals($zahlRichtig,
                            $wertungType->convertToPHPValue($zahlkodiert, new MySqlPlatform())
                                ->getRichtigFalschWeissnichtWertung()
                                ->getPunktzahlRichtig()->getValue());
        $this->assertEquals($zahlFalsch,
                            $wertungType->convertToPHPValue($zahlkodiert, new MySqlPlatform())
                                ->getRichtigFalschWeissnichtWertung()
                                ->getPunktzahlFalsch()->getValue());
        $this->assertEquals($zahlWeissnicht,
                            $wertungType->convertToPHPValue($zahlkodiert, new MySqlPlatform())
                                ->getRichtigFalschWeissnichtWertung()
                                ->getPunktzahlWeissnicht()->getValue());
    }
}
