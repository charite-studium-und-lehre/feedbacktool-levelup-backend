<?php

namespace DatenImport\Domain;

use ConvenientImmutability\Immutable;
use Pruefung\Domain\FrageAntwort\AntwortCode;
use Pruefung\Domain\FrageAntwort\AntwortText;
use Pruefung\Domain\FrageAntwort\FragenNummer;
use Pruefung\Domain\FrageAntwort\FragenText;
use Pruefung\Domain\PruefungsId;

class ChariteFragenDTO
{
    use Immutable;

    /** @var FragenNummer */
    public $fragenNr;

    /** @var AntwortCode */
    public $loesung;

    /** @var int */
    public $semester;

    /** @var PruefungsId */
    public $pruefungsId;

    /** @var FragenText */
    public $fragenText;

    /** @var AntwortText[] */
    public $antworten;

    /** @var boolean */
    public $mitAbbildung;

}