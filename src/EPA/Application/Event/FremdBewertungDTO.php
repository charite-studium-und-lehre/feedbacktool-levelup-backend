<?php

namespace EPA\Application\Event;

use ConvenientImmutability\Immutable;

class FremdBewertungDTO
{
    use Immutable;

    /** @var int */
    public $epaId;

    /** @var int */
    public $fremdBewertung;
}
