<?php

namespace DatenImport\Infrastructure\Persistence;

use Exception;

abstract class AbstractCSVImportService
{
    const OUT_ENCODING = "UTF-8";
    const DEFAULT_DELIMITER = ";";

    /** @var array<string, string> */
    private array $options;

    /** @param array<string, string> $options */
    public function __construct(array $options = []) {
        $this->options = $options;
    }

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

        while (($dataLine = fgetcsv($handle, NULL, $delimiter)) !== FALSE) {
            $counter++;
            $dataLineFixed = [];
            foreach ($dataLine as $dataCell) {
                if (!is_string($dataCell) && !is_numeric($dataCell)) {
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

    protected function trimDataCell(string $string): string {
        return trim($string);
    }

}