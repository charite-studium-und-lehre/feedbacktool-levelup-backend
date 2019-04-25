<?php

namespace Studi\Domain\Service;

use Studi\Domain\Geburtsdatum;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\Nachname;
use Studi\Domain\StudiHash;
use Studi\Domain\Vorname;

interface StudiHashCreator
{
    public function createStudiHash(
        Matrikelnummer $matrikelnummer,
        Vorname $vorname,
        Nachname $nachname,
        Geburtsdatum $geburtsdatum
    ): StudiHash;

    public function isCorrectStudiHash(
        StudiHash $studiHash,
        Matrikelnummer $matrikelnummer,
        Vorname $vorname,
        Nachname $nachname,
        Geburtsdatum $geburtsdatum
    ): bool;

}