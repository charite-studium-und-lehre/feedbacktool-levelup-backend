<?php

namespace Studi\Domain\Service;

use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\Nachname;
use Studi\Domain\StudiData;
use Studi\Domain\StudiHash;
use Studi\Domain\Vorname;

interface StudiHashCreator
{
    public function createStudiHash(
        StudiData $studiData
    ): StudiHash;

    public function isCorrectStudiHash(
        StudiHash $studiHash,
        StudiData $studiData
    ): bool;

}