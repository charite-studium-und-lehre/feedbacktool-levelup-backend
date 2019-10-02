<?php

namespace Pruefung\Domain;

use Common\Domain\AggregateIdString;

class PruefungsId extends AggregateIdString
{
    public static function fromPruefungsformatUndPeriode(
        PruefungsFormat $pruefungsFormat,
        PruefungsPeriode $periode,
        string $suffix = ""
    ): PruefungsId {
        $idString = $pruefungsFormat->getCode() . "-" . $periode->toInt();
        if ($suffix) {
            $idString .= "-$suffix";
        }

        return PruefungsId::fromString($idString);
    }
}