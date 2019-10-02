<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use ConvenientImmutability\Immutable;
use Pruefung\Domain\PruefungsPeriode;

class ImportOptionenDTO
{
    use Immutable;

    /** @var string */
    public $dateiPfad;

    /** @var string */
    public $delimiter;

    /** @var string */
    public $encoding;

    /** @var boolean */
    public $hasHeaders;

    /** @var PruefungsPeriode */
    public $pruefungsPeriode;

}