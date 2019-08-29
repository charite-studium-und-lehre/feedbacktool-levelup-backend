<?php

namespace DatenImport\Domain;

use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;
use Studi\Domain\StudiData;

interface StudiStammdatenImportService
{
    /** @return StudiData[] */
    public function getStudiData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    ): array;
}