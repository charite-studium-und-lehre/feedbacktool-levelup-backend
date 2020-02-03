<?php

namespace DatenImport\Domain;

interface PruefungsdatenImportService
{
    const DEFAULT_OUT_ENCODING = "UTF-8";

    /** @return array<int, array<string,mixed>> */
    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = self::DEFAULT_OUT_ENCODING
    ): array;
}