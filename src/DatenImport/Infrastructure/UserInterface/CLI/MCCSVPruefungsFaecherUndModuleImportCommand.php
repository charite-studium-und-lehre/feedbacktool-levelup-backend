<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

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

    /** @var Charite_Ergebnisse_CSVImportService */
    private $chariteMCErgebnisseCSVImportService;

    /** @var ChariteMCPruefungLernzielModulPersistenzService */
    private $chariteMCPruefungLernzielModulPersistenz;

    /** @var ChariteLernzielModulImportCSVService */
    private $chariteLernzielModulImportCSVService;

    public function __construct(
        Charite_Ergebnisse_CSVImportService $chariteMCErgebnisseCSVImportService,
        ChariteMCPruefungLernzielModulPersistenzService $chariteMCPruefungLernzielModulPersistenz,
        ChariteLernzielModulImportCSVService $chariteLernzielModulImportCSVService
    ) {
        $this->chariteMCErgebnisseCSVImportService = $chariteMCErgebnisseCSVImportService;
        $this->chariteMCPruefungLernzielModulPersistenz = $chariteMCPruefungLernzielModulPersistenz;
        $this->chariteLernzielModulImportCSVService = $chariteLernzielModulImportCSVService;
        parent::__construct();
    }




    protected function configure() {
        $this->addArgumentDateiPfad();
        $this->addArgument('dateiPfadLzModule', InputArgument::REQUIRED, 'Der volle Pfad zur Lernziel-Modul-CSV-Datei');
        $this->addArgument('pruefungsID', InputArgument::REQUIRED, 'Die Kurz-Bezeichnung der Prüfung');
        $this->addArgument('delimiterLzModule', InputArgument::OPTIONAL, 'Das CSV-Trennezichen für die Lernziel-Modul-Datei');
        $this->addAndereArgumente();


        $this->setDescription('Datenimport aus Datei: Modul- und Fächerzuordnung MC-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <MC-CSV-Dateipfad> <Lernziel-Modul-CSV-Dateipfad>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        [$dateiPfad, $delimiter, $encoding, $hasHeaders, $pruefungsId] = $this->getParameters($input);
        $dateiPfadLzModule = $input->getArgument("dateiPfadLzModule");
        $delimiterLzModule = $input->getArgument("delimiterLzModule") ?: ";";

        $mcPruefungsDaten = $this->chariteMCErgebnisseCSVImportService->getData(
            $dateiPfad, $delimiter, $hasHeaders, $encoding, $pruefungsId,
        );

        $lzModulDaten = $this->chariteLernzielModulImportCSVService->getLernzielZuModulData(
            $dateiPfadLzModule,$delimiterLzModule, $hasHeaders, $encoding
        );

        $output->writeln(count($mcPruefungsDaten) . " Zeilen gelesen. Persistiere.");

        $this->chariteMCPruefungLernzielModulPersistenz->persistiereMcModulZuordnung(
            $mcPruefungsDaten, $lzModulDaten
        );

        $output->writeln("\nFertig. "
                         . $this->chariteMCPruefungWertungPersistenzService->getHinzugefuegt() . " Zeilen hinzugefügt; "
                         . $this->chariteMCPruefungWertungPersistenzService->getGeaendert() . " Zeilen geändert; "
                         . count($this->chariteMCPruefungWertungPersistenzService->getNichtZuzuordnen())
                         . " Matrikelnummern nicht zuzuordnen; "
        );

    }

}