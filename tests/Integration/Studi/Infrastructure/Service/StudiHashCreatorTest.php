<?php

namespace Tests\Integration\Studi\Infrastructure;

use Common\Domain\User\Nachname;
use Common\Domain\User\Vorname;
use PHPUnit\Framework\TestCase;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiData;
use Studi\Infrastructure\Service\StudiHashCreator_Argon2I;

class StudiHashCreatorTest extends TestCase
{
    public function getImplementations() {

        return [
            'argon2i' => [new StudiHashCreator_Argon2I()],
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
                Nachname::fromString("Meier"),
                Geburtsdatum::fromStringDeutsch("12.04.1980"),
                []
            )
        );
        $studiHash2 = $hashCreator->createStudiHash(
            StudiData::fromValues(
                Matrikelnummer::fromInt(456789),
                Vorname::fromString("Petra-Maria"),
                Nachname::fromString("Maier"),
                Geburtsdatum::fromStringDeutsch("12.04.1980"),
                []
            )
        );
        $this->assertFalse($studiHash1->equals($studiHash2));
    }
}