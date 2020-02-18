<?php

namespace Studi\Infrastructure\Service;

use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiData;
use Studi\Domain\StudiHash;

class StudiHashCreator_SHA256 extends AbstractHashCreator implements StudiHashCreator
{
    public function createStudiHash(StudiData $studiData): StudiHash {
        $stringToHash = $this->getStringToHash($studiData);

        return StudiHash::fromString(
            $this->createHash($stringToHash)
        );
    }

    public function isCorrectStudiHash(StudiHash $studiHash, StudiData $studiData): bool {
        $stringToHash = $this->getStringToHash($studiData);

        return $this->verifyHash($stringToHash, $studiHash->getValue());
    }

    private function getStringToHash(StudiData $studiData): string {
        $matrikelnummer = $studiData->getMatrikelnummer();
        $vorname = $studiData->getVorname();
        $nachname = $studiData->getNachname();

        return $matrikelnummer
            . self::SEPARATOR . $vorname
            . self::SEPARATOR . $nachname;
    }

}