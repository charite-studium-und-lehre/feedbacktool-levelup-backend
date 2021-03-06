<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\StudiStammdatenPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudiImportCommand extends AbstractCSVImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:studi';

    private ChariteStudiStammdatenHIS_CSVImportService $chariteStudiStammdatenHIS_CSVImportService;

    private StudiStammdatenPersistenzService $studiStammdatenPersistenzService;

    public function __construct(
        ChariteStudiStammdatenHIS_CSVImportService $chariteStudiStammdatenHIS_CSVImportService,
        StudiStammdatenPersistenzService $studiStammdatenPersistenzService
    ) {
        $this->chariteStudiStammdatenHIS_CSVImportService = $chariteStudiStammdatenHIS_CSVImportService;
        $this->studiStammdatenPersistenzService = $studiStammdatenPersistenzService;
        parent::__construct();
    }

    protected function configure() {
        parent::configure();
        $this->setDescription('Studi-Datenimport aus Datei');
        $this->setHelp("Aufruf: bin/console l:i:studi <CSV-Dateipfad>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $importOptionenDTO = $this->getParameters($input);
        $delimiter = (string) $input->getArgument("delimiter") ?: ";";
        $encoding = (string) $input->getArgument("encoding") ?: "ISO-8859-15";

        $studiObjects = $this->chariteStudiStammdatenHIS_CSVImportService->getStudiData(
            $importOptionenDTO->dateiPfad, $delimiter,
            $importOptionenDTO->hasHeaders, $encoding);

        $output->writeln(count($studiObjects) . " Studis in Datei gefunden!");
        $output->writeln("Persistiere!");

        $this->studiStammdatenPersistenzService->persistiereStudiListe($studiObjects);
        $output->writeln("");
        $output->writeln(
            $this->studiStammdatenPersistenzService->getHinzugefuegt() . " hinzugefügt; " .
            $this->studiStammdatenPersistenzService->getGeloescht() . " gelöscht; " .
            $this->studiStammdatenPersistenzService->getGeaendert() . " geändert; "
        );

        return 0;
    }

}