<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\StudiStammdatenPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
use Studi\Domain\Service\StudiHashCreator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudiImportCommand extends AbstractCSVImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:studi';

    /** @var ChariteStudiStammdatenHIS_CSVImportService */
    private $chariteStudiStammdatenHIS_CSVImportService;

    /** @var StudiHashCreator */
    private $studiHashCreator;

    /** @var StudiStammdatenPersistenzService */
    private $studiStammdatenPersistenzService;

    public function __construct(
        ChariteStudiStammdatenHIS_CSVImportService $chariteStudiStammdatenHIS_CSVImportService,
        StudiStammdatenPersistenzService $studiStammdatenPersistenzService,
        StudiHashCreator $studiHashCreator
    ) {
        $this->chariteStudiStammdatenHIS_CSVImportService = $chariteStudiStammdatenHIS_CSVImportService;
        $this->studiHashCreator = $studiHashCreator;
        $this->studiStammdatenPersistenzService = $studiStammdatenPersistenzService;
        parent::__construct();
    }

    protected function configure() {
        parent::configure();
        $this->setDescription('Studi-Datenimport aus Datei');
        $this->setHelp("Aufruf: bin/console l:i:studi <CSV-Dateipfad>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        [$dateiPfad, $delimiter, $encoding, $hasHeaders] = $this->getParameters($input);
        $delimiter = $input->getArgument("delimiter") ?: ";";


        $studiObjects = $this->chariteStudiStammdatenHIS_CSVImportService->getStudiData(
            $dateiPfad, $delimiter, $hasHeaders, $encoding);

        $output->writeln(count($studiObjects) . " Studis in Datei gefunden!");
        $output->writeln("Persistiere!");

        $this->studiStammdatenPersistenzService->persistiereStudiListe($studiObjects);
        $output->writeln("");
        $output->writeln(
            $this->studiStammdatenPersistenzService->getHinzugefuegt() . " hinzugefügt; " .
            $this->studiStammdatenPersistenzService->getGeloescht() . " gelöscht; " .
            $this->studiStammdatenPersistenzService->getGeaendert() . " geändert; "
        );

    }

}