<?php

namespace Pruefung\Domain;

use Common\Domain\AggregateIdString;
use Pruefung\Domain\FrageAntwort\FragenNummer;

class PruefungsItemId extends AggregateIdString
{
    public static function fromPruefungsIdUndFragenNummer(
        PruefungsId $pruefungsId,
        FragenNummer $fragenNummer
    ): self {
        return self::fromString(
            $pruefungsId->getValue() . "-" . $fragenNummer->getValue()
        );
    }

}