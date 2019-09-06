<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MCCSVPruefungsImportCommand extends AbstractCSVPruefungsImportCommand
{
    /** @var PruefungsRepository */
    private $pruefungsRepository;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:mcCSVWertung';

    /** @var Charite_Ergebnisse_CSVImportService */
    private $chariteMCErgebnisseCSVImportService;

    /** @var ChariteMCPruefungWertungPersistenzService */
    private $chariteMCPruefungWertungPersistenzService;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        Charite_Ergebnisse_CSVImportService $chariteMCErgebnisseCSVImportService,
        ChariteMCPruefungWertungPersistenzService $chariteMCPruefungWertungPersistenzService
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->chariteMCErgebnisseCSVImportService = $chariteMCErgebnisseCSVImportService;
        $this->chariteMCPruefungWertungPersistenzService = $chariteMCPruefungWertungPersistenzService;
        parent::__construct();
    }

    protected function configure() {
        parent::configure();
        $this->setDescription('Datenimport aus Datei: MC-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <CSV-Dateipfad> <Datum>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        [$dateiPfad, $datum, $delimiter, $encoding, $hasHeaders] = $this->getParameters($input);

        $pruefungsId = $this->erzeugePruefung($output, PruefungsFormat::getMC(),
                                              $datum, $this->pruefungsRepository
        );


        $mcPruefungsDaten = $this->chariteMCErgebnisseCSVImportService->getData(
            $dateiPfad, $delimiter, $hasHeaders, $encoding, $pruefungsId
        );
        $output->writeln(count($mcPruefungsDaten) . " Zeilen gelesen. Persistiere.");

        $this->chariteMCPruefungWertungPersistenzService->persistierePruefung($mcPruefungsDaten, $pruefungsId);

        $output->writeln("\nFertig. "
                         . $this->chariteMCPruefungWertungPersistenzService->getHinzugefuegt() . " Zeilen hinzugefügt; "
                         . $this->chariteMCPruefungWertungPersistenzService->getGeaendert() . " Zeilen geändert; "
                         . count($this->chariteMCPruefungWertungPersistenzService->getNichtZuzuordnen())
                         . " Matrikelnummern nicht zuzuordnen; "
        );

    }

}