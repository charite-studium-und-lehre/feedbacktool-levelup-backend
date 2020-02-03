<?php

namespace EPA\Application\Event;

use ConvenientImmutability\Immutable;

class FremdBewertungDTO
{
    use Immutable;

    public int $epaId;

    public int $fremdBewertung;
}
