<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use mysql_xdevapi\Exception;
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

    /**
     * @param InputInterface $input
     * @return array
     * @throws \Exception
     */
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

    /**
     * @param OutputInterface $output
     * @param PruefungsFormat $pruefungsFormat
     * @param $periode
     * @return PruefungsId
     */
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

    protected function pruefeHatUnterPeriode(PruefungsPeriode $periode) {
        if (!$periode->getUnterPeriode()) {
            throw new InvalidArgumentException("Parameter Periode: Dieser Import braucht verpflichtend auch eine Unterperiode (6-stellige Periode) (Periode <Jahr><Halbjahr><Unterperiode>)");
        }
    }

    protected function pruefeHatKeineUnterPeriode(PruefungsPeriode $periode) {
        if ($periode->getUnterPeriode()) {

            throw new InvalidArgumentException("Parameter Periode: Dieser Import darf keine Unterperiode haben (5-stellige Periode) (Periode <Jahr><Halbjahr>)");
        }
    }


    private function computeFileNameToPruefungsId(string $filename): PruefungsId {
        $filename = basename($filename);
        $semester = substr(explode("_", $filename)[1], 0, 8);
        $durchlauf = substr(explode("_", $filename)[2], 0, 1);

        return PruefungsId::fromString("MC-$semester-$durchlauf");
    }

}