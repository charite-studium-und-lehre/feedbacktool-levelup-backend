<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteMC_Ergebnisse_CSVImportService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MCCSVImportCommand extends AbstractCSVImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:mcCSV';

    /** @var ChariteMC_Ergebnisse_CSVImportService */
    private $chariteMCErgebnisseCSVImportService;

    /** @var ChariteMCPruefungWertungPersistenzService */
    private $chariteMCPruefungWertungPersistenzService;

    /** @var ChariteMCPruefungFachPersistenzService */
    private $chariteMCPruefungFachPersistenzService;

    /** @var ChariteMCPruefungLernzielModulPersistenzService */
    private $chariteMCPruefungLernzielModulPersistenz;

    public function __construct(
        ChariteMC_Ergebnisse_CSVImportService $chariteMCErgebnisseCSVImportService,
        ChariteMCPruefungWertungPersistenzService $chariteMCPruefungWertungPersistenzService,
        ChariteMCPruefungFachPersistenzService $chariteMCPruefungFachPersistenzService,
        ChariteMCPruefungLernzielModulPersistenzService $chariteMCPruefungLernzielModulPersistenz
    ) {
        $this->chariteMCErgebnisseCSVImportService = $chariteMCErgebnisseCSVImportService;
        $this->chariteMCPruefungWertungPersistenzService = $chariteMCPruefungWertungPersistenzService;
        $this->chariteMCPruefungFachPersistenzService = $chariteMCPruefungFachPersistenzService;
        $this->chariteMCPruefungLernzielModulPersistenz = $chariteMCPruefungLernzielModulPersistenz;

        parent::__construct();
    }

    protected function configure() {
        parent::configure();
        $this->setDescription('Datenimport aus Datei: MC-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <CSV-Dateipfad> <Pruefungs-ID>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        [$dateiPfad, $delimiter, $encoding, $pruefungsId] = $this->getParameters($input);

        $data = $this->chariteMCErgebnisseCSVImportService->getData(
            $dateiPfad, $delimiter, TRUE, $encoding, $pruefungsId
        );
        $output->writeln(sizeof($data));

    }

}