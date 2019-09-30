<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\CharitePTMPersistenzService;
use DatenImport\Infrastructure\Persistence\CharitePTMCSVImportService;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PTMCSVPruefungsImportCommand extends AbstractCSVPruefungsImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:ptm';

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var CharitePTMCSVImportService */
    private $charitePTMCSVImportService;

    /** @var CharitePTMPersistenzService */
    private $charitePTMPersistenzService;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        CharitePTMCSVImportService $charitePTMCSVImportService,
        CharitePTMPersistenzService $charitePTMPersistenzService
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->charitePTMCSVImportService = $charitePTMCSVImportService;
        $this->charitePTMPersistenzService = $charitePTMPersistenzService;
        parent::__construct();
    }

    protected function configure() {
        parent::configure();
        $this->setDescription('Datenimport aus Datei: PTM-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <CSV-Dateipfad> <Pruefungsperiode>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $importOptionenDTO = $this->getParameters($input);
        $delimiter = $input->getArgument("delimiter") ?: ";";
        $this->pruefeHatKeineUnterPeriode($importOptionenDTO->pruefungsPeriode);

        $pruefungsId = $this->erzeugePruefung($output, PruefungsFormat::getPTM(),
                                              $importOptionenDTO->pruefungsPeriode, $this->pruefungsRepository
        );

        $ptmPruefungsDaten = $this->charitePTMCSVImportService->getData(
            $importOptionenDTO->dateiPfad, $delimiter,
            $importOptionenDTO->hasHeaders, $importOptionenDTO->encoding,
            $pruefungsId
        );
        $output->writeln(count($ptmPruefungsDaten) . " Zeilen gelesen. Persistiere.");

        $this->charitePTMPersistenzService->persistierePruefung($ptmPruefungsDaten, $pruefungsId);

        $output->writeln("\nFertig. ");

    }

}