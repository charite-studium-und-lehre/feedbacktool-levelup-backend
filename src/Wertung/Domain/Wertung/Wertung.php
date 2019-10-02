<?php

namespace Wertung\Domain\Wertung;

use Common\Domain\DDDValueObject;
use Wertung\Domain\Skala\Skala;

interface Wertung extends DDDValueObject
{
    public function getRelativeWertung(): float;

    public function getSkala(): Skala;
}