<?php

namespace Pruefung\Domain;

use Common\Domain\AggregateIdString;

class PruefungsId extends AggregateIdString
{
    public static function fromPruefungsformatUndDatum(
        PruefungsFormat $pruefungsFormat,
        PruefungsDatum $datum,
        string $suffix = ""
    ): PruefungsId {
        $idString = $pruefungsFormat->getCode() . "-" . $datum->toIsoString();
        if ($suffix) {
            $idString .= "-$suffix";
        }
        return PruefungsId::fromString($idString);
    }
}