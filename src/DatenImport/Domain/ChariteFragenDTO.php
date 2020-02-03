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

    public FragenNummer $fragenNr;

    public AntwortCode $loesung;

    public int $semester;

    public PruefungsId $pruefungsId;

    public FragenText $fragenText;

    /** @var array<string, AntwortText> */
    public array $antworten;

    public bool $mitAbbildung;

}