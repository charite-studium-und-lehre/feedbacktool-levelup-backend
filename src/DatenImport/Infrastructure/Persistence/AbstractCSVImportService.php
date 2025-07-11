<?php

namespace DatenImport\Infrastructure\Persistence;

use Exception;

abstract class AbstractCSVImportService
{
    const OUT_ENCODING = "UTF-8";
    const DEFAULT_DELIMITER = ";";

    /** @return array<array<string,string>> */
    protected function getCSVDataAsArray(
        string $inputFile,
        string $delimiter = self::DEFAULT_DELIMITER,
        bool $hasHeaders = TRUE,
        string $fromEncoding = self::OUT_ENCODING
    ): array {
        $handle = fopen($inputFile, "r");

        $dataAsArray = [];
        $headers = [];
        $counter = 0;

        while (($dataLine = fgetcsv($handle, NULL, $delimiter, escape: '\\')) !== FALSE) {
            $counter++;
            $dataLineFixed = [];
            foreach ($dataLine as $dataCell) {
                if ((!$dataCell && $dataCell !== "0" && $dataCell !== 0) ||
                    (!is_string($dataCell) && !is_numeric($dataCell))) {
                    $dataCell = "";
                }
                $dataCell = $this->fixEncoding((string) $dataCell, $fromEncoding);
                $dataCell = $this->trimDataCell($dataCell);
                $dataLineFixed[] = $dataCell;
            }
            if ($hasHeaders && $counter == 1) {
                $headers = $dataLineFixed;
                continue;
            }
            if (!implode("", $dataLineFixed)) {
                continue;
            }
            if ($hasHeaders) {
                if (count($headers) != count($dataLineFixed)) {
                    dump($headers);
                    dump($dataLineFixed);
                    echo "\nZeile: $counter";
                    throw new Exception("Header-Anzahl passt nicht zu Daten: $inputFile!");
                }
                $dataLineFixed = array_combine($headers, $dataLineFixed);
            }

            $dataAsArray[] = $dataLineFixed;

        }

        return $dataAsArray;
    }

    protected function trimDataCell(string $string): string {
        return trim($string);
    }

    private function fixEncoding(
        string $string,
        string $fromEncoding,
        string $toEncoding = self::OUT_ENCODING
    ): string {
        if ($fromEncoding != $toEncoding) {
            return iconv($fromEncoding, $toEncoding, $string);
        }

        return $string;
    }

}