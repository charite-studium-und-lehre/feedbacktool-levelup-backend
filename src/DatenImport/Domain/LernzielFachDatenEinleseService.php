<?php

namespace DatenImport\Domain;

interface LernzielFachDatenEinleseService
{
    const DEFAULT_OUT_ENCODING = "UTF-8";

    /** @return array<int LernzielNummer, string FachCode */
    public function getData(
        string $inputFile,
        string $delimiter = ",",
        bool $hasHeaders = TRUE,
        string $fromEncoding = self::DEFAULT_OUT_ENCODING
    );
}