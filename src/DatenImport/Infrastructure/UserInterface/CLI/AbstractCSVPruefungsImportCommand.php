<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use Pruefung\Domain\PruefungsId;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

abstract class AbstractCSVPruefungsImportCommand extends AbstractCSVImportCommand
{
    protected function configure() {
        $this->addArgumentDateiPfad();
        $this->addArgument('pruefungsID', InputArgument::REQUIRED, 'Die Kurz-Bezeichnung der Prüfung');
        $this->addAndereArgumente();
    }

    /**
     * @param InputInterface $input
     * @return array
     * @throws \Exception
     */
    protected function getParameters(InputInterface $input): array {
        $pruefungsId = PruefungsId::fromString($input->getArgument("pruefungsID"));

        return array_merge(parent::getParameters($input), [$pruefungsId]);
    }


    private function computeFileNameToPruefungsId(string $filename): PruefungsId {
        $filename = basename($filename);
        $semester = substr(explode("_", $filename)[1], 0, 8);
        $durchlauf = substr(explode("_", $filename)[2], 0, 1);

        return PruefungsId::fromString("MC-$semester-$durchlauf");
    }


}