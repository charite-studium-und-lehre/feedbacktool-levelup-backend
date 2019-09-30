<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\Charite_Ergebnisse_CSVImportService;
use mysql_xdevapi\Exception;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MCCSVPruefungsImportCommand extends AbstractCSVPruefungsImportCommand
{
    protected static $defaultName = 'levelup:importFile:mcCSVWertung';

    // the name of the command (the part after "bin/console")

    /** @var PruefungsRepository */
    private $pruefungsRepository;

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
        $this->setHelp("Aufruf: bin/console l:i:mc <CSV-Dateipfad> <Prüfungsperiode>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $importOptionenDTO = $this->getParameters($input);
        $this->pruefeHatUnterPeriode($importOptionenDTO->pruefungsPeriode);

        foreach (PruefungsFormat::MC_KONSTANTEN_NACH_FACHSEMESTER as $MC_Konstante) {
            $this->erzeugePruefung($output, PruefungsFormat::fromConst($MC_Konstante),
                                   $importOptionenDTO->pruefungsPeriode, $this->pruefungsRepository
            );
        }

        $mcPruefungsDaten = $this->chariteMCErgebnisseCSVImportService->getData(
            $importOptionenDTO->dateiPfad, $importOptionenDTO->delimiter,
            $importOptionenDTO->hasHeaders, $importOptionenDTO->encoding,
            $importOptionenDTO->pruefungsPeriode
        );
        $output->writeln("\n" . count($mcPruefungsDaten) . " Zeilen gelesen. Persistiere.");

        $this->chariteMCPruefungWertungPersistenzService->persistierePruefung($mcPruefungsDaten);

        $output->writeln("\nFertig. "
                         . $this->chariteMCPruefungWertungPersistenzService->getHinzugefuegt() . " Zeilen hinzugefügt; "
                         . $this->chariteMCPruefungWertungPersistenzService->getGeaendert() . " Zeilen geändert; "
                         . count($this->chariteMCPruefungWertungPersistenzService->getNichtZuzuordnen())
                         . " Matrikelnummern nicht zuzuordnen; "
        );

    }

}