<?php

namespace Pruefung\Domain\FrageAntwort;

use Common\Domain\AggregateIdString;

class AntwortId extends AggregateIdString
{
    public static function fromFragenIdUndCode(
        FragenId $fragenId,
        AntwortCode $antwortCode
    ): self {
        return self::fromString($fragenId->getValue() . "-" . $antwortCode->getValue());

    }
}