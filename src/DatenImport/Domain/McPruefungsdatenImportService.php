<?php

namespace DatenImport\Domain;

interface McPruefungsdatenImportService
{
    public function getMCData(): array;
}