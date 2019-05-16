<?php

namespace DatenImport\Infrastructure\Persistence;

abstract class AbstractCSVImportService
{
    const INPUTFILE_OPTION = "INPUTFILE";
    const FROM_ENCODING_OPTION = "FROM_ENCODING";
    const DELIMITER_OPTION = "DELIMITER";
    const HAS_HEADERS_OPTION = "HAS_HEADERS";

    const OUT_ENCODING="UTF-8";
    const DEFAULT_DELIMITER=";";

    /** @var array */
    private $options;

    public function __construct($options = []) {
        $this->options = $options;
    }

    protected function getCSVDataAsArray(): array {
        $inputFile = $this->options[self::INPUTFILE_OPTION];
        if (!$inputFile) {
            throw new \Exception("inputFile must be given");
        }
        $handle = fopen($inputFile, "r");

        $dataAsArray = [];
        $delimiter = $this->getDelimiterOption();
        $hasHeaders = $this->hasHeaders();
        $headers = [];
        $counter = 0;

        while (($dataLine = fgetcsv($handle, NULL, $delimiter)) !== FALSE) {
            $counter++;
            $dataLineFixed = [];
            foreach ($dataLine as $dataCell) {
                $dataCell = $this->fixEncoding($dataCell);
                $dataCell = $this->trimDataCell($dataCell);
                $dataLineFixed[] = $dataCell;
            }
            if ($hasHeaders && $counter == 1) {
                $headers = $dataLineFixed;
                continue;
            }
            if ($hasHeaders) {
                $dataLineFixed = array_combine($headers, $dataLine);
            }

            $dataAsArray[] = $dataLineFixed;

        }

        return $dataAsArray;
    }

    protected function fixEncoding($string) {
        if (!empty($this->options[self::FROM_ENCODING_OPTION])) {
            return iconv($this->options[self::FROM_ENCODING_OPTION], self::OUT_ENCODING, $string);
        }
        return $string;
    }

    protected function trimDataCell($string) {
        return trim($string);
    }

    private function getDelimiterOption() : string {
        if (!empty($this->options[self::DELIMITER_OPTION])) {
            return $this->options[self::DELIMITER_OPTION];
        }
        return self::DEFAULT_DELIMITER;
    }

    private function hasHeaders() : bool {
        if (!empty($this->options[self::HAS_HEADERS_OPTION])) {
            return $this->options[self::HAS_HEADERS_OPTION];
        }
        return FALSE;
    }

}