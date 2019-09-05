<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MCCSVPruefungsImportCommand extends AbstractCSVPruefungsImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:mcCSV';

    /** @var Charite_Ergebnisse_CSVImportService */
    private $chariteMCErgebnisseCSVImportService;

    /** @var ChariteMCPruefungFachPersistenzService */
    private $chariteMCPruefungFachPersistenzService;

    /** @var ChariteMCPruefungLernzielModulPersistenzService */
    private $chariteMCPruefungLernzielModulPersistenz;

    public function __construct(
        Charite_Ergebnisse_CSVImportService $chariteMCErgebnisseCSVImportService,
        ChariteMCPruefungFachPersistenzService $chariteMCPruefungFachPersistenzService,
        ChariteMCPruefungLernzielModulPersistenzService $chariteMCPruefungLernzielModulPersistenz
    ) {
        $this->chariteMCErgebnisseCSVImportService = $chariteMCErgebnisseCSVImportService;
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

        $mcPruefungsDaten = $this->chariteMCErgebnisseCSVImportService->getData(
            $dateiPfad, $delimiter, TRUE, $encoding, $pruefungsId
        );
        $lzModulDaten = $this->

        $output->writeln(count($mcPruefungsDaten) . " Zeilen gelesen. Persistiere.");

        $this->chariteMCPruefungFachPersistenzService->persistiereFachZuordnung($mcPruefungsDaten);
        $this->chariteMCPruefungLernzielModulPersistenz->persistiereMcModulZuordnung($mcPruefungsDaten);

        $output->writeln("\nFertig. "
                         . $this->chariteMCPruefungWertungPersistenzService->getHinzugefuegt() . " Zeilen hinzugefügt; "
                         . $this->chariteMCPruefungWertungPersistenzService->getGeaendert() . " Zeilen geändert; "
                         . count($this->chariteMCPruefungWertungPersistenzService->getNichtZuzuordnen()) . " Matrikelnummern nicht zuzuordnen; "
        );

    }

}