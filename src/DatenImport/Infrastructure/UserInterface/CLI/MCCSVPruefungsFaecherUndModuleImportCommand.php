<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteLernzielModulImportCSVService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MCCSVPruefungsFaecherUndModuleImportCommand extends AbstractCSVPruefungsImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:mcCSVFachUndModule';

    private Charite_Ergebnisse_CSVImportService $chariteMCErgebnisseCSVImportService;

    private ChariteMCPruefungLernzielModulPersistenzService $chariteMCPruefungLernzielModulPersistenz;

    /** ChariteMCPruefungFachPersistenzService */
    private ChariteMCPruefungFachPersistenzService $chariteMCPruefungFachPersistenzService;

    private ChariteLernzielModulImportCSVService $chariteLernzielModulImportCSVService;

    public function __construct(
        Charite_Ergebnisse_CSVImportService $chariteMCErgebnisseCSVImportService,
        ChariteMCPruefungLernzielModulPersistenzService $chariteMCPruefungLernzielModulPersistenz,
        ChariteMCPruefungFachPersistenzService $chariteMCPruefungFachPersistenzService,
        ChariteLernzielModulImportCSVService $chariteLernzielModulImportCSVService
    ) {
        $this->chariteMCErgebnisseCSVImportService = $chariteMCErgebnisseCSVImportService;
        $this->chariteMCPruefungLernzielModulPersistenz = $chariteMCPruefungLernzielModulPersistenz;
        $this->chariteMCPruefungFachPersistenzService = $chariteMCPruefungFachPersistenzService;
        $this->chariteLernzielModulImportCSVService = $chariteLernzielModulImportCSVService;
        parent::__construct();
    }

    protected function configure() {
        $this->addArgumentDateiPfad();
        $this->addArgument('dateiPfadLzModule', InputArgument::REQUIRED, 'Der volle Pfad zur Lernziel-Modul-CSV-Datei');
        $this->addArgumentPeriode();
        $this->addArgument('delimiterLzModule', InputArgument::OPTIONAL,
                           'Das CSV-Trennezichen für die Lernziel-Modul-Datei');
        $this->addAndereArgumente();

        $this->setDescription('Datenimport aus Datei: Modul- und Fächerzuordnung MC-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <MC-CSV-Dateipfad> <Lernziel-Modul-CSV-Dateipfad>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $importOptionen = $this->getParameters($input);
        $dateiPfadLzModule = (string) $input->getArgument("dateiPfadLzModule");
        $delimiterLzModule = (string) $input->getArgument("delimiterLzModule") ?: ";";

        $mcPruefungsDaten = $this->chariteMCErgebnisseCSVImportService->getData(
            $importOptionen->dateiPfad, $importOptionen->delimiter,
            $importOptionen->hasHeaders, $importOptionen->encoding,
            $importOptionen->pruefungsPeriode,
            );

        $lzModulDaten = $this->chariteLernzielModulImportCSVService->getLernzielZuModulData(
            $dateiPfadLzModule, $delimiterLzModule, $importOptionen->hasHeaders, $importOptionen->encoding
        );

        $output->writeln(count($mcPruefungsDaten) . " Zeilen gelesen. ");
        $output->writeln("");
        $output->writeln("Persistiere Module...");

        $this->chariteMCPruefungLernzielModulPersistenz->persistiereMcModulZuordnung(
            $mcPruefungsDaten, $lzModulDaten
        );

        $output->writeln("");
        $output->writeln("Persistiere Fächer...");

        $this->chariteMCPruefungFachPersistenzService->persistiereFachZuordnung(
            $mcPruefungsDaten
        );

        $output->writeln("\nFertig. ");

        return 0;
    }

}