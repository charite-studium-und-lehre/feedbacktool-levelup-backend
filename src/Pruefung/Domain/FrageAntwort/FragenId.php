<?php

namespace Pruefung\Domain\FrageAntwort;

use Common\Domain\AggregateIdString;
use Pruefung\Domain\PruefungsItemId;

class FragenId extends AggregateIdString
{
    public static function fromPruefungItemIdUndFragenNummer(
        PruefungsItemId $pruefungsItemId,
        FragenNummer $fragenNummer
    ): self {
        return self::fromString($pruefungsItemId->getValue());

    }
}