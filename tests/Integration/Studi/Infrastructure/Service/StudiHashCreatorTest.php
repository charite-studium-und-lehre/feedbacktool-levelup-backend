<?php

namespace Tests\Integration\Studi\Infrastructure;

use Common\Domain\User\Nachname;
use Common\Domain\User\Vorname;
use PHPUnit\Framework\TestCase;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiData;
use Studi\Infrastructure\Service\StudiHashCreator_SHA256;

class StudiHashCreatorTest extends TestCase
{
    public function getImplementations() {

        return [
            'sha256' => [new StudiHashCreator_SHA256("secret")],
        ];
    }

    /**
     * @dataProvider getImplementations
     */
    public function testCreateHash(StudiHashCreator $hashCreator) {
        $studiHash1 = $hashCreator->createStudiHash(
            StudiData::fromValues(
                Matrikelnummer::fromInt(456789),
                Vorname::fromString("Petra-Maria"),
                Nachname::fromString("Meier")
            )
        );
        $studiHash2 = $hashCreator->createStudiHash(
            StudiData::fromValues(
                Matrikelnummer::fromInt(456789),
                Vorname::fromString("Petra-Maria"),
                Nachname::fromString("Maier")
            )
        );
        $this->assertFalse($studiHash1->equals($studiHash2));
    }
}