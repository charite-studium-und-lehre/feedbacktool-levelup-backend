<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteStationenPruefungPersistenzService;
use DatenImport\Domain\ChariteStationsClusterungPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteStationenErgebnisse_CSVImportService;
use Exception;
use Pruefung\Domain\PruefungsFormat;
use Pruefung\Domain\PruefungsRepository;
use StudiPruefung\Domain\Service\ItemWertungDurchschnittPersistenzService;
use StudiPruefung\Domain\Service\StudiPruefungDurchschnittPersistenzService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StationenCSVPruefungsImportCommand extends AbstractCSVPruefungsImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:stationen';

    private PruefungsRepository $pruefungsRepository;

    private ChariteStationenErgebnisse_CSVImportService $chariteStationenErgebnisseCSVImportService;

    private ChariteStationenPruefungPersistenzService $chariteStationenPruefungPersistenzService;

    private StudiPruefungDurchschnittPersistenzService $studiPruefungDurchschnittPersistenzService;

    private ItemWertungDurchschnittPersistenzService $itemWertungDurchschnittPersistenzService;

    private ChariteStationsClusterungPersistenzService $chariteStationsClusterungPersistenzService;

    /**
     * StationenCSVPruefungsImportCommand constructor.
     *
     * @param PruefungsRepository $pruefungsRepository
     * @param ChariteStationenErgebnisse_CSVImportService $chariteStationenErgebnisseCSVImportService
     * @param ChariteStationenPruefungPersistenzService $chariteStationenPruefungPersistenzService
     * @param StudiPruefungDurchschnittPersistenzService $studiPruefungDurchschnittPersistenzService
     * @param ItemWertungDurchschnittPersistenzService $itemWertungDurchschnittPersistenzService
     * @param ChariteStationsClusterungPersistenzService $chariteStationsClusterungPersistenzService
     */
    public function __construct(
        PruefungsRepository $pruefungsRepository,
        ChariteStationenErgebnisse_CSVImportService $chariteStationenErgebnisseCSVImportService,
        ChariteStationenPruefungPersistenzService $chariteStationenPruefungPersistenzService,
        StudiPruefungDurchschnittPersistenzService $studiPruefungDurchschnittPersistenzService,
        ItemWertungDurchschnittPersistenzService $itemWertungDurchschnittPersistenzService,
        ChariteStationsClusterungPersistenzService $chariteStationsClusterungPersistenzService
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->chariteStationenErgebnisseCSVImportService = $chariteStationenErgebnisseCSVImportService;
        $this->chariteStationenPruefungPersistenzService = $chariteStationenPruefungPersistenzService;
        $this->studiPruefungDurchschnittPersistenzService = $studiPruefungDurchschnittPersistenzService;
        $this->itemWertungDurchschnittPersistenzService = $itemWertungDurchschnittPersistenzService;
        $this->chariteStationsClusterungPersistenzService = $chariteStationsClusterungPersistenzService;
        parent::__construct();
    }

    protected function configure() {
        $this->addArgumentDateiPfad();
        $this->addArgumentPeriode();
        $this->addArgument('stationsTeil', InputArgument::REQUIRED, 'Teil1VK, Teil1K, Teil2, Teil3 oder Sem9');
        $this->addAndereArgumente();
        $this->setDescription('Datenimport aus Datei: Stationen-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <CSV-Dateipfad> <Datum> <Stations-Teil>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $importOptionenDTO = $this->getParameters($input);
        $this->pruefeHatUnterPeriode($importOptionenDTO->pruefungsPeriode);

        $pruefungsFormat = $this->getPruefungsFormat($input);

        $pruefungsId = $this->erzeugePruefung($output, $pruefungsFormat,
                                              $importOptionenDTO->pruefungsPeriode,
                                              $this->pruefungsRepository
        );

        $stationsPruefungsDaten = $this->chariteStationenErgebnisseCSVImportService->getData(
            $importOptionenDTO->dateiPfad, $importOptionenDTO->delimiter,
            $importOptionenDTO->hasHeaders, $importOptionenDTO->encoding
        );
        $output->writeln(count($stationsPruefungsDaten) . " Zeilen gelesen. Persistiere.");

        $this->chariteStationenPruefungPersistenzService
            ->persistierePruefung($stationsPruefungsDaten, $pruefungsId);

        $output->writeln("Persistiere Durchschnittswerte der Einzel-Items...");
        $this->itemWertungDurchschnittPersistenzService
            ->berechneUndPersistiereDurchschnitt($pruefungsId);
        $output->writeln("");
        $output->writeln("Persistiere Durchschnittswerte der Gesamtwertungen...");
        $this->studiPruefungDurchschnittPersistenzService
            ->berechneUndPersistiereGesamtDurchschnitt($pruefungsId);

        $output->writeln("Persistiere Cluster-Zuordnungen...");
        $this->chariteStationsClusterungPersistenzService
            ->persistiereClusterZuordnungen($stationsPruefungsDaten, $pruefungsId);

        $output->writeln("\nFertig. ");

        return 0;
    }

    protected function getPruefungsFormat(InputInterface $input): PruefungsFormat {
        $pruefungsTeil = $input->getArgument("stationsTeil");
        switch ($pruefungsTeil) {
            case 'Teil1VK':
                return PruefungsFormat::getStationTeil1Vorklinik();
            case 'Teil1K':
                return PruefungsFormat::getStationTeil1Klinik();
            case 'Teil2':
                return PruefungsFormat::getStationTeil2();
            case 'Teil3':
                return PruefungsFormat::getStationTeil3();
            case 'Sem9':
                return PruefungsFormat::getStationOsceSem9();
            default:
                throw new Exception("Falsches Format: $pruefungsTeil");
        }
    }

}