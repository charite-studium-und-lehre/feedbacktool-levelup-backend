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

    public \Pruefung\Domain\FrageAntwort\FragenNummer $fragenNr;

    public \Pruefung\Domain\FrageAntwort\AntwortCode $loesung;

    public int $semester;

    public \Pruefung\Domain\PruefungsId $pruefungsId;

    public \Pruefung\Domain\FrageAntwort\FragenText $fragenText;

    /** @var AntwortText[] */
    public array $antworten;

    public bool $mitAbbildung;

}