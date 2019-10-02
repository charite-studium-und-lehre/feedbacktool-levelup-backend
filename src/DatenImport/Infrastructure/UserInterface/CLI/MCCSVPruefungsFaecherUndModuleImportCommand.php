<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteLernzielModulImportCSVService;
use Pruefung\Domain\PruefungsRepository;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MCCSVPruefungsFaecherUndModuleImportCommand extends AbstractCSVPruefungsImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:mcCSVFachUndModule';

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var Charite_Ergebnisse_CSVImportService */
    private $chariteMCErgebnisseCSVImportService;

    /** @var ChariteMCPruefungLernzielModulPersistenzService */
    private $chariteMCPruefungLernzielModulPersistenz;

    /** ChariteMCPruefungFachPersistenzService */
    private $chariteMCPruefungFachPersistenzService;

    /** @var ChariteLernzielModulImportCSVService */
    private $chariteLernzielModulImportCSVService;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        Charite_Ergebnisse_CSVImportService $chariteMCErgebnisseCSVImportService,
        ChariteMCPruefungLernzielModulPersistenzService $chariteMCPruefungLernzielModulPersistenz,
        ChariteMCPruefungFachPersistenzService $chariteMCPruefungFachPersistenzService,
        ChariteLernzielModulImportCSVService $chariteLernzielModulImportCSVService
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
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
        [$dateiPfad, $datum, $delimiter, $encoding, $hasHeaders] = $this->getParameters($input);
        $dateiPfadLzModule = $input->getArgument("dateiPfadLzModule");
        $delimiterLzModule = $input->getArgument("delimiterLzModule") ?: ";";

        $mcPruefungsDaten = $this->chariteMCErgebnisseCSVImportService->getData(
            $dateiPfad, $delimiter, $hasHeaders, $encoding, $datum,
            );

        $lzModulDaten = $this->chariteLernzielModulImportCSVService->getLernzielZuModulData(
            $dateiPfadLzModule, $delimiterLzModule, $hasHeaders, $encoding
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

    }

}