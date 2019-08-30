<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteMCPruefungFachPersistenzService;
use DatenImport\Domain\ChariteMCPruefungLernzielModulPersistenzService;
use DatenImport\Domain\ChariteMCPruefungWertungPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteMC_Ergebnisse_CSVImportService;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudiImportCommand extends AbstractCSVImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:studi';

    /** @var ChariteStudiStammdatenHIS_CSVImportService */
    private $chariteStudiStammdatenHIS_CSVImportService;

    public function __construct(ChariteStudiStammdatenHIS_CSVImportService $chariteStudiStammdatenHIS_CSVImportService
    ) {
        $this->chariteStudiStammdatenHIS_CSVImportService = $chariteStudiStammdatenHIS_CSVImportService;
        parent::__construct();
    }

    protected function configure() {
        parent::configure();
        $this->setDescription('Datenimport aus Datei: MC-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <CSV-Dateipfad> <Pruefungs-ID>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        [$dateiPfad, $delimiter, $encoding, $pruefungsId] = $this->getParameters($input);

        $data = $this->chariteStudiStammdatenHIS_CSVImportService->getStudiData(
            $dateiPfad, $delimiter, TRUE, $encoding, $pruefungsId
        );
        $output->writeln(sizeof($data));

    }

}