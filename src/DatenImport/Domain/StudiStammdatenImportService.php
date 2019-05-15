<?php

namespace DatenImport\Domain;

use Studi\Domain\StudiData;

interface StudiStammdatenImportService
{
    /** @return StudiData[] */
    public function getStudiData(array $importSettings = []): array;
}