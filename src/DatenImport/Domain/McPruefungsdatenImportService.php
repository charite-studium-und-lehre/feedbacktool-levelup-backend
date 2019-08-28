<?php

namespace DatenImport\Domain;

use Pruefung\Domain\PruefungsId;

interface McPruefungsdatenImportService
{
    public function getData(?PruefungsId $pruefungsId = NULL): array;
}