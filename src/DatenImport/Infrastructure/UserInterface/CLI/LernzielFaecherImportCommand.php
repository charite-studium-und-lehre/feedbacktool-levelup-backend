<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use DatenImport\Domain\ChariteFaecherAnlegenService;
use DatenImport\Domain\ChariteLernzielFachPersistenzService;
use DatenImport\Infrastructure\Persistence\ChariteLernzielFachEinleseCSVService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LernzielFaecherImportCommand extends AbstractCSVImportCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'levelup:importFile:lernzielFaecher';

    private \DatenImport\Domain\ChariteFaecherAnlegenService $chariteFaecherAnlegenService;

    private \DatenImport\Domain\ChariteLernzielFachPersistenzService $chariteLernzielFachPersistenzService;

    private \DatenImport\Infrastructure\Persistence\ChariteLernzielFachEinleseCSVService $chariteLernzielFachEinleseCSVService;

    public function __construct(
        ChariteFaecherAnlegenService $chariteFaecherAnlegenService,
        ChariteLernzielFachPersistenzService $chariteLernzielFachPersistenzService,
        ChariteLernzielFachEinleseCSVService $chariteLernzielFachEinleseCSVService
    ) {
        $this->chariteFaecherAnlegenService = $chariteFaecherAnlegenService;
        $this->chariteLernzielFachPersistenzService = $chariteLernzielFachPersistenzService;
        $this->chariteLernzielFachEinleseCSVService = $chariteLernzielFachEinleseCSVService;
        parent::__construct();
    }

    protected function configure() {
        parent::configure();

        $this->setDescription('Datenimport aus Datei: Fächerzuordnung MC-Prüfung in CSV-Datei');
        $this->setHelp("Aufruf: bin/console l:i:mc <CSV-LernzielFächer.csv>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $importOptionenDTO = $this->getParameters($input);

        $delimiter = $input->getArgument("delimiter") ?: ";";
        $encoding = $input->getArgument("delimiter") ?: "ISO-8859-15";

        $this->chariteFaecherAnlegenService->addAlleFaecherZuDB();

        $lernzielFaecher = $this->chariteLernzielFachEinleseCSVService->getData(
            $importOptionenDTO->dateiPfad, $delimiter,
            $importOptionenDTO->hasHeaders, $encoding
        );

        $output->writeln(count($lernzielFaecher) . " lernziel-Fach-Zeilen gelesen. Persistiere.");
        $this->chariteLernzielFachPersistenzService->persistiereLernzielFaecher($lernzielFaecher);

        return 0;

    }

}