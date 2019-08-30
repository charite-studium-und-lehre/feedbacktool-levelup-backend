<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use Pruefung\Domain\PruefungsId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

abstract class AbstractCSVImportCommand extends Command
{
    protected function configure() {
        $this->addArgument('dateiPfad', InputArgument::REQUIRED, 'Der volle Pfad zur CSV-Datei');
        $this->addArgument('pruefungsID', InputArgument::REQUIRED, 'Die Kurz-Bezeichnung der Prüfung');
        $this->addArgument('delimiter', InputArgument::OPTIONAL, 'Das Trennzeichen der CSV-Datei (Standard: ,');
        $this->addArgument('encoding', InputArgument::OPTIONAL, 'Die Kodierung der CSV-Datei (Standard: UTF-8)');
        $this->addArgument('hasHeaders', InputArgument::OPTIONAL, 'CSV-Datei hat Header-Zeile (Default: 1)');
    }

    /**
     * @param InputInterface $input
     * @return array
     * @throws \Exception
     */
    protected function getParameters(InputInterface $input): array {
        $dateiPfad = $input->getArgument("dateiPfad");
        $delimiter = $input->getArgument("delimiter") ?: ",";
        $encoding = $input->getArgument("encoding") ?: "UTF-8";

        $this->checkDelimiter($delimiter);
        $this->checkEncoding($encoding);

        $pruefungsId = PruefungsId::fromString($input->getArgument("pruefungsID"));

        return array($dateiPfad, $delimiter, $encoding, $pruefungsId);
    }

    protected function checkEncoding(?string $encoding): void {
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

    private function computeFileNameToPruefungsId(string $filename): PruefungsId {
        $filename = basename($filename);
        $semester = substr(explode("_", $filename)[1], 0, 8);
        $durchlauf = substr(explode("_", $filename)[2], 0, 1);

        return PruefungsId::fromString("MC-$semester-$durchlauf");
    }

    private function checkDelimiter(string $delimiter): void {
        if (strlen($delimiter) !== 1) {
            throw new \Exception("'$delimiter' ist als Zeichentrenner nicht gültig!");
        }
    }

}