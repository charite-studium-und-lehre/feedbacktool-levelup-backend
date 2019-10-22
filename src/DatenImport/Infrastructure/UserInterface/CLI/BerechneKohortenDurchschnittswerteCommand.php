<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use Pruefung\Domain\PruefungsRepository;
use StudiPruefung\Domain\Service\ItemWertungDurchschnittPersistenzService;
use StudiPruefung\Domain\Service\StudiPruefungDurchschnittPersistenzService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BerechneKohortenDurchschnittswerteCommand extends Command
{
    protected static $defaultName = 'levelup:importFile:berechneKohortenDurchschnittswerte';

    // the name of the command (the part after "bin/console")

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var StudiPruefungDurchschnittPersistenzService */
    private $studiPruefungDurchschnittPersistenzService;

    /** @var ItemWertungDurchschnittPersistenzService */
    private $itemWertungDurchschnittPersistenzService;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        StudiPruefungDurchschnittPersistenzService $studiPruefungDurchschnittPersistenzService,
        ItemWertungDurchschnittPersistenzService $itemWertungDurchschnittPersistenzService
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->studiPruefungDurchschnittPersistenzService = $studiPruefungDurchschnittPersistenzService;
        $this->itemWertungDurchschnittPersistenzService = $itemWertungDurchschnittPersistenzService;
        parent::__construct();
    }

    protected function configure() {
        $this->setDescription('Berechnet alle Durchschnittswerte');
        $this->setHelp("Aufruf: bin/console l:i:studi <CSV-Dateipfad>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln("Persistiere Durchschnittswerte der Gesamtwertungen");
        $this->studiPruefungDurchschnittPersistenzService
            ->berechneUndPersistiereGesamtDurchschnitt();
        $output->writeln("Persistiere Durchschnittswerte der Einzel-Items");
        $this->itemWertungDurchschnittPersistenzService
            ->berechneUndPersistiereDurchschnitt();

    }

}