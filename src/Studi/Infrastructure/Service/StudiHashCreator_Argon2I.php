<?php

namespace Studi\Infrastructure\Service;

use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiData;
use Studi\Domain\StudiHash;

class StudiHashCreator_Argon2I extends AbstractHashCreator implements StudiHashCreator
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
        // TODO: App-Secret verwenden
        $matrikelnummer = $studiData->getMatrikelnummer();
        $vorname = $studiData->getVorname();
        $nachname = $studiData->getNachname();
        //        $geburtsdatum = $studiData->getGeburtsdatum();

        $hash_string = $matrikelnummer
            . self::SEPARATOR . $vorname
            . self::SEPARATOR . $nachname;

        return $hash_string;
    }

}