<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use ConvenientImmutability\Immutable;
use Pruefung\Domain\PruefungsPeriode;

class ImportOptionenDTO
{
    use Immutable;

    public string $dateiPfad;

    public string $delimiter;

    public string $encoding;

    public bool $hasHeaders;

    public PruefungsPeriode $pruefungsPeriode;

}