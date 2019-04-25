<?php

namespace Studi\Infrastructure\Service;

use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\Nachname;
use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\StudiHash;
use Studi\Domain\Vorname;

class StudiHashCreator_Argon2I implements StudiHashCreator
{

    const SEPARATOR = "|";

    public function createStudiHash(
        Matrikelnummer $matrikelnummer,
        Vorname $vorname,
        Nachname $nachname,
        Geburtsdatum $geburtsdatum
    ): StudiHash {

        $stringToHash = $this->getStringToHash(
            $matrikelnummer,
            $vorname,
            $nachname,
            $geburtsdatum
        );

        return StudiHash::fromString(
            $this->executeHashing($stringToHash)
        );
    }

    public function isCorrectStudiHash(
        StudiHash $studiHash,
        Matrikelnummer $matrikelnummer,
        Vorname $vorname,
        Nachname $nachname,
        Geburtsdatum $geburtsdatum
    ): bool {
        $stringToHash = $this->getStringToHash(
            $matrikelnummer,
            $vorname,
            $nachname,
            $geburtsdatum
        );
        return password_verify($stringToHash, $studiHash->getValue());
    }

    /**
     * @param Matrikelnummer $matrikelnummer
     * @param Vorname $vorname
     * @param Nachname $nachname
     * @param Geburtsdatum $geburtsdatum
     * @return string
     */
    private function getStringToHash(
        Matrikelnummer $matrikelnummer,
        Vorname $vorname,
        Nachname $nachname,
        Geburtsdatum $geburtsdatum
    ): string {
        // TODO: App-Secret verwenden
        $hash_string = "$vorname|$nachname|$matrikelnummer|$geburtsdatum";

        return $hash_string;
    }

    /**
     * @param $hash_string
     */
    private function executeHashing($stringToHash): string {
        $options = [
            'memory_cost' => 1 << 12, // 4 KB
            'time_cost'   => 10,
            'threads'     => 2,
        ];

        return password_hash($stringToHash, PASSWORD_ARGON2I, $options);
    }


}