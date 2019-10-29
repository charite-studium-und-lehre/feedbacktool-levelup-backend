<?php

namespace DatenImport\Infrastructure\Persistence;

abstract class AbstractCSVImportService
{
    const OUT_ENCODING = "UTF-8";
    const DEFAULT_DELIMITER = ";";

    /** @var array */
    private $options;

    public function __construct($options = []) {
        $this->options = $options;
    }

    protected function getCSVDataAsArray(
        string $inputFile,
        string $delimiter = self::DEFAULT_DELIMITER,
        bool $hasHeaders = TRUE,
        $fromEncoding = self::OUT_ENCODING
    ): array {
        $handle = fopen($inputFile, "r");

        $dataAsArray = [];
        $headers = [];
        $counter = 0;

        while (($dataLine = fgetcsv($handle, NULL, $delimiter)) !== FALSE) {
            $counter++;
            $dataLineFixed = [];
            foreach ($dataLine as $dataCell) {
                $dataCell = $this->fixEncoding($dataCell, $fromEncoding);
                $dataCell = $this->trimDataCell($dataCell);
                $dataLineFixed[] = $dataCell;
            }
            if ($hasHeaders && $counter == 1) {
                $headers = $dataLineFixed;
                continue;
            }
            if (!implode("",$dataLineFixed)) {
                continue;
            }
            if ($hasHeaders) {
                if (count($headers) != count($dataLineFixed)) {
                    dump($headers);
                    dump($dataLineFixed);
                    echo "\nZeile: $counter";
                    throw new \Exception("Header-Anzahl passt nicht zu Daten!");
                }
                $dataLineFixed = array_combine($headers, $dataLineFixed);
            }

            $dataAsArray[] = $dataLineFixed;

        }

        return $dataAsArray;
    }

    protected function fixEncoding($string, $fromEncoding, $toEncoding = self::OUT_ENCODING) {
        if ($fromEncoding != $toEncoding) {
            return iconv($fromEncoding, $toEncoding, $string);
        }

        return $string;
    }

    protected function trimDataCell($string) {
        return trim($string);
    }

}