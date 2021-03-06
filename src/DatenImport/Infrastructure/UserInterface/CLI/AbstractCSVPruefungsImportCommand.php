<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use Pruefung\Domain\Pruefung;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsId;
use Pruefung\Domain\PruefungsPeriode;
use Pruefung\Domain\PruefungsRepository;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCSVPruefungsImportCommand extends AbstractCSVImportCommand
{
    protected function configure() {
        $this->addArgumentDateiPfad();
        $this->addArgumentPeriode();
        $this->addAndereArgumente();
    }

    protected function getParameters(InputInterface $input): ImportOptionenDTO {
        $periode = PruefungsPeriode::fromInt((int) $input->getArgument("periode"));

        $importOptionenDTO = parent::getParameters($input);
        $importOptionenDTO->pruefungsPeriode = $periode;

        return $importOptionenDTO;
    }

    protected function addArgumentPeriode(): void {
        $this->addArgument('periode', InputArgument::REQUIRED,
                           'Die Prüfungsperiode. 20181 Für SoSe2018; 20182 für WiSe2018; 201811 für SoSe2018, Unterperiode 1');
    }

    protected function erzeugePruefung(
        OutputInterface $output,
        PruefungsFormat $pruefungsFormat,
        PruefungsPeriode $periode,
        PruefungsRepository $pruefungsRepository
    ): PruefungsId {
        $pruefungsId = PruefungsId::fromPruefungsformatUndPeriode($pruefungsFormat, $periode);
        $output->write("\nPrüfungs-ID: '" . $pruefungsId->getValue() . "' ");
        $pruefung = $pruefungsRepository->byId($pruefungsId);
        if (!$pruefung) {
            $pruefung = Pruefung::create(
                $pruefungsId, $periode, $pruefungsFormat
            );
            $pruefungsRepository->add($pruefung);
            $pruefungsRepository->flush();
            $output->writeln("-> angelegt.");
        } else {
            $output->writeln("-> schon vorhanden.");
        }

        return $pruefungsId;
    }

    protected function pruefeHatUnterPeriode(PruefungsPeriode $periode): void {
        if (!$periode->getUnterPeriode()) {
            throw new InvalidArgumentException("Parameter Periode: Dieser Import braucht verpflichtend auch eine Unterperiode (6-stellige Periode) (Periode <Jahr><Halbjahr><Unterperiode>)");
        }
    }

    protected function pruefeHatKeineUnterPeriode(PruefungsPeriode $periode): void {
        if ($periode->getUnterPeriode()) {
            throw new InvalidArgumentException("Parameter Periode: Dieser Import darf keine Unterperiode haben (5-stellige Periode) (Periode <Jahr><Halbjahr>)");
        }
    }

}