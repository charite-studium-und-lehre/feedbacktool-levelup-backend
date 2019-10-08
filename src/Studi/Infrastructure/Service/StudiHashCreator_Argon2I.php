<?php

namespace Studi\Infrastructure\Service;

use Common\Domain\User\Nachname;
use Common\Domain\User\Vorname;
use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiData;
use Studi\Domain\StudiHash;

class StudiHashCreator_Argon2I implements StudiHashCreator
{

    const SEPARATOR = "|";

    const OPTIONS = [
        'memory_cost' => 1 << 12, // 4 KB
        'time_cost'   => 10,
        'threads'     => 2,
    ];

    public function createStudiHash(StudiData $studiData): StudiHash {
        $stringToHash = $this->getStringToHash($studiData);

        return StudiHash::fromString(
            $this->executeHashing($stringToHash)
        );
    }

    public function isCorrectStudiHash(StudiHash $studiHash, StudiData $studiData): bool {
        $stringToHash = $this->getStringToHash($studiData);

        return password_verify($stringToHash, $studiHash->getValue());
    }

    /**
     * @param Matrikelnummer $matrikelnummer
     * @param Vorname $vorname
     * @param \Common\Domain\User\Nachname $nachname
     * @param Geburtsdatum $geburtsdatum
     * @return string
     */
    private function getStringToHash(StudiData $studiData): string {
        // TODO: App-Secret verwenden
        $matrikelnummer = $studiData->getMatrikelnummer();
        $vorname = $studiData->getVorname();
        $nachname = $studiData->getNachname();
        //        $geburtsdatum = $studiData->getGeburtsdatum();

        $hash_string = "$matrikelnummer|$vorname|$nachname";

        return $hash_string;
    }

    /**
     * @param $hash_string
     */
    private function executeHashing($stringToHash): string {
        return password_hash($stringToHash, PASSWORD_ARGON2I, self::OPTIONS);
    }

}