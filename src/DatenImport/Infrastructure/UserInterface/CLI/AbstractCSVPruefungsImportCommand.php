<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsDatum;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsRepository;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCSVPruefungsImportCommand extends AbstractCSVImportCommand
{
    protected function configure() {
        $this->addArgumentDateiPfad();
        $this->addArgumentDatum();
        $this->addAndereArgumente();
    }

    /**
     * @param InputInterface $input
     * @return array
     * @throws \Exception
     */
    protected function getParameters(InputInterface $input): array {
        $datum = PruefungsDatum::fromString($input->getArgument("datum"));

        $parameters = parent::getParameters($input);
        $datei = array_shift($parameters);

        return array_merge([$datei, $datum], $parameters);
    }

    protected function addArgumentDatum(): void {
        $this->addArgument('datum', InputArgument::REQUIRED, 'Das ungefähre Datum der Prüfung (d.m.Y)');
    }

    /**
     * @param OutputInterface $output
     * @param PruefungsFormat $pruefungsFormat
     * @param $datum
     * @return PruefungsId
     */
    protected function erzeugePruefung(
        OutputInterface $output,
        PruefungsFormat $pruefungsFormat,
        PruefungsDatum $datum,
        PruefungsRepository $pruefungsRepository
    ): PruefungsId {
        $pruefungsId = PruefungsId::fromPruefungsformatUndDatum($pruefungsFormat, $datum);
        $output->write("\nPrüfungs-ID: '" . $pruefungsId->getValue() . "' ");
        $pruefung = $pruefungsRepository->byId($pruefungsId);
        if (!$pruefung) {
            $pruefung = Pruefung::create(
                $pruefungsId, $datum, $pruefungsFormat
            );
            $pruefungsRepository->add($pruefung);
            $pruefungsRepository->flush();
            $output->writeln("-> angelegt.");
        } else {
            $output->writeln("-> schon vorhanden.");
        }

        return $pruefungsId;
    }

    private function computeFileNameToPruefungsId(string $filename): PruefungsId {
        $filename = basename($filename);
        $semester = substr(explode("_", $filename)[1], 0, 8);
        $durchlauf = substr(explode("_", $filename)[2], 0, 1);

        return PruefungsId::fromString("MC-$semester-$durchlauf");
    }

}