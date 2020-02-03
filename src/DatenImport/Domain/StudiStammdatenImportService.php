<?php

namespace DatenImport\Domain;

use Studi\Domain\StudiData;

interface StudiStammdatenImportService
{
    const DEFAULT_OUT_ENCODING = "UTF-8";

    /** @return StudiData[] */
    public function getStudiData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = self::DEFAULT_OUT_ENCODING
    ): array;
}