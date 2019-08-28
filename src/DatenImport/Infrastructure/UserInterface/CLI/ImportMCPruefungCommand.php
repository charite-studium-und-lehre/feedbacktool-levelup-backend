<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteMC_Ergebnisse_CSVImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportMCPruefungCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:mcCSV';

    public function __construct(
        ChariteMC_Ergebnisse_CSVImportService $chariteMCErgebnisseCSVImport,
        ChariteMCPruefungWertungPersistenzService $chariteMCPruefungWertungPersistenz,
        ChariteMCPruefungFachPersistenzService $chariteMCPruefungFachPersistenz,
        ChariteMCPruefungLernzielModulPersistenzService $chariteMCPruefungLernzielModulPersistenz
    ) {

    }

    protected function configure() {
        $this->setDescription('Datenimport aus Datei: MC-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <CSV-Dateipfad>"
                       . "\nCSV-Datei muss UTF8-kodiert sein!");

        $this->addArgument('dateiPfad', InputArgument::REQUIRED, 'Der volle Pfad zur CSV-Datei');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // ...
    }
}