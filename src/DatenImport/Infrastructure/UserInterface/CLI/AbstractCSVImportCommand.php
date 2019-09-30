<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

abstract class AbstractCSVImportCommand extends Command
{
    protected function configure() {
        $this->addArgumentDateiPfad();
        $this->addAndereArgumente();
    }

    /**
     * @param InputInterface $input
     * @return array
     * @throws \Exception
     */
    protected function getParameters(InputInterface $input): ImportOptionenDTO {
        $dateiPfad = $input->getArgument("dateiPfad");
        $delimiter = $input->getArgument("delimiter") ?: ",";
        $encoding = $input->getArgument("encoding") ?: "UTF-8";
        $hasHeaders = $input->getArgument("hasHeaders") ?: TRUE;

        $this->checkDelimiter($delimiter);
        $this->checkEncoding($encoding);

        $importOptionenDTO = new ImportOptionenDTO();
        $importOptionenDTO->dateiPfad = $dateiPfad;
        $importOptionenDTO->delimiter = $delimiter;
        $importOptionenDTO->encoding = $encoding;
        $importOptionenDTO->hasHeaders = $hasHeaders;
        return $importOptionenDTO;
    }

    protected function addArgumentDateiPfad(): void {
        $this->addArgument('dateiPfad', InputArgument::REQUIRED, 'Der volle Pfad zur CSV-Datei');
    }

    protected function addAndereArgumente(): void {
        $this->addArgument('delimiter', InputArgument::OPTIONAL, 'Das Trennzeichen der CSV-Datei (Standard: ,');
        $this->addArgument('encoding', InputArgument::OPTIONAL, 'Die Kodierung der CSV-Datei (Standard: UTF-8)');
        $this->addArgument('hasHeaders', InputArgument::OPTIONAL, 'CSV-Datei hat Header-Zeile (Default: 1)');
    }

    private function checkEncoding(?string $encoding): void {
        if (!$encoding) {
            return;
        }
        $success = FALSE;
        try {
            $success = iconv($encoding, "UTF-8", "a");
        } catch (\Exception $e) {
        }
        if (!$success) {
            if (strlen($encoding) !== 1) {
                throw new \Exception("'$encoding' nicht als Kodierung erkannt! Ein Liste aller verfügbaren Kodierungen erhalten Sie durch 'iconv -l'");
            }
        }
    }

    private function checkDelimiter(string $delimiter): void {
        if (strlen($delimiter) !== 1) {
            throw new \Exception("'$delimiter' ist als Zeichentrenner nicht gültig!");
        }
    }

}