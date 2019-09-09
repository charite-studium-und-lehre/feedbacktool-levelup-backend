<?php

namespace EPA\Domain;

use Common\Domain\DefaultValueObjectComparison;

class EPABewertung
{
    use DefaultValueObjectComparison;

    const BEWERTUNG_MIN = 0;
    const BEWERTUNG_MAX = 5;

    const BEWERTUNG_BESCHREIBUNG = [
        0 => "nix",
        1 => "Stufe 1",
        2 => "Stufe 2",
        3 => "Stufe 3",
        4 => "Stufe 4",
        5 => "Stufe 5 - allein",
    ];

    public function fromInt(string $bewertung) {

    }

}