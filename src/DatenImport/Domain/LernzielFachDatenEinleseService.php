<?php

namespace DatenImport\Domain;

use DatenImport\Infrastructure\Persistence\AbstractCSVImportService;

interface LernzielFachDatenEinleseService
{
    /** @return array<int LernzielNummer, string FachCode */
    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = AbstractCSVImportService::OUT_ENCODING
    );
}