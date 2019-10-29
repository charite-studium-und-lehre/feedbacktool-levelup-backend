<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteFragenPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteFragenCSVImportService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MCFragenAntwortenImportCommand extends AbstractCSVPruefungsImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:mcFragenTexte';

    /** @var ChariteFragenCSVImportService */
    private $chariteFragenCSVImportService;

    /** @var ChariteFragenPersistenzService */
    private $chariteFragenPersistenzService;

    public function __construct(
        ChariteFragenCSVImportService $chariteFragenCSVImportService,
        ChariteFragenPersistenzService $chariteFragenPersistenzService
    ) {
        $this->chariteFragenCSVImportService = $chariteFragenCSVImportService;
        $this->chariteFragenPersistenzService = $chariteFragenPersistenzService;
        parent::__construct();
    }

    protected function configure() {
        parent::configure();

        $this->setDescription('Datenimport aus Datei: MC-Fragen und -antworten in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mcFragenTexte <CSV-Dateipfad> <Prüfungsperiode>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $importOptionenDTO = $this->getParameters($input);
        $this->pruefeHatUnterPeriode($importOptionenDTO->pruefungsPeriode);

        $fragenDTOs = $this->chariteFragenCSVImportService->getData(
            $importOptionenDTO->dateiPfad, $importOptionenDTO->pruefungsPeriode,
            $importOptionenDTO->delimiter, $importOptionenDTO->hasHeaders,
            $importOptionenDTO->encoding
        );

        $output->writeln("\n" . count($fragenDTOs) . " Zeilen gelesen. Persistiere.");

        $this->chariteFragenPersistenzService->persistiereFragenUndAntworten($fragenDTOs);

        $output->writeln("\nFertig. ");

    }

}