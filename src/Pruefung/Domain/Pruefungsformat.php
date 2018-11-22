<?php

namespace Pruefung\Domain;

use Assert\Assertion;
use Common\Domain\DefaultValueObjectComparison;

class Pruefungsformat
{
    use DefaultValueObjectComparison;

    const MC_FORMAT = 10;

    const PTM_FORMAT = 20;


    const FORMAT_KONSTANTEN = [
        self::MC_FORMAT,
        self::PTM_FORMAT
    ];

    const INVALID_PRUEFUNGSFORMAT = "Kein gültiges Prüfungsformat: ";

    private $pruefungsformat;

    public static function fromInt(int $format): self {

        Assertion::inArray($format, self::FORMAT_KONSTANTEN, self::INVALID_PRUEFUNGSFORMAT . $format);

        $object = new self();
        $object->pruefungsformat = $format;

        return $object;
    }

    public function getPruefungsformat() {
        return $this->pruefungsformat;

    }
}