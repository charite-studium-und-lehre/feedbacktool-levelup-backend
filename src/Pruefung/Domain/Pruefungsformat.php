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

    private $format;

    private $kommentar;


    public static function fromInt(int $format,  String $kommentar = NULL): self {

        Assertion::inArray($format, self::FORMAT_KONSTANTEN, self::INVALID_PRUEFUNGSFORMAT . $format);

        $object = new self();
        $object->format = $format;
        $object->kommentar = $kommentar;

        return $object;
    }

    public function getFormat() {
        return $this->format;

    }

    public function getKommentar(){
        return $this->kommentar;
    }

}