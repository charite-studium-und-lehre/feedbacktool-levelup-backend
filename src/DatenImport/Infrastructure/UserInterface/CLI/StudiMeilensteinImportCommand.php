<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\StudiMeilensteinPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteStudiStammdatenHIS_CSVImportService;
use Studi\Domain\Service\StudiHashCreator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudiMeilensteinImportCommand extends AbstractCSVImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:StudiMeilenstein';

    private ChariteStudiStammdatenHIS_CSVImportService $chariteStudiStammdatenHIS_CSVImportService;

    private StudiHashCreator $studiHashCreator;

    private StudiMeilensteinPersistenzService $StudiMeilensteinPersistenzService;

    public function __construct(
        ChariteStudiStammdatenHIS_CSVImportService $chariteStudiStammdatenHIS_CSVImportService,
        StudiMeilensteinPersistenzService $StudiMeilensteinPersistenzService,
        StudiHashCreator $studiHashCreator
    ) {
        $this->chariteStudiStammdatenHIS_CSVImportService = $chariteStudiStammdatenHIS_CSVImportService;
        $this->studiHashCreator = $studiHashCreator;
        $this->StudiMeilensteinPersistenzService = $StudiMeilensteinPersistenzService;
        parent::__construct();
    }

    protected function configure(): void {
        parent::configure();
        $this->setDescription('Studi-Meilenstein-Datenimport aus Datei');
        $this->setHelp("Aufruf: bin/console l:i:StudiMeilenstein <CSV-Dateipfad>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $importOptionenDTO = $this->getParameters($input);
        $delimiter = (string) $input->getArgument("delimiter") ?: ";";

        $studiObjects = $this->chariteStudiStammdatenHIS_CSVImportService->getStudiData(
            $importOptionenDTO->dateiPfad, $delimiter,
            $importOptionenDTO->hasHeaders, $importOptionenDTO->encoding);

        $output->writeln(count($studiObjects) . " Studis in Datei gefunden!");
        $output->writeln("Persistiere Meilensteine!");

        $this->StudiMeilensteinPersistenzService->persistiereStudiListe($studiObjects);
        $output->writeln("");
        $output->writeln(
            $this->StudiMeilensteinPersistenzService->getHinzugefuegt() . " hinzugefügt; " .
            $this->StudiMeilensteinPersistenzService->getGeloescht() . " gelöscht; "
        );

        return 0;
    }

}