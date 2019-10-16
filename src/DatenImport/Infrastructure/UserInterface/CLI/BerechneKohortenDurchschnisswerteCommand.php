<?php

namespace DatenImport\Infrastructure\UserInterface\CLI;

use Pruefung\Domain\PruefungsRepository;
use StudiPruefung\Domain\Service\StudiPruefungDurchschnittPersistenzService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BerechneKohortenDurchschnisswerteCommand extends Command
{
    protected static $defaultName = 'levelup:importFile:berechneKohortenDurchschnisswerte';

    // the name of the command (the part after "bin/console")

    /** @var PruefungsRepository */
    private $pruefungsRepository;



    /** @var StudiPruefungDurchschnittPersistenzService */
    private $studiPruefungDurchschnittPersistenzService;

    public function __construct(
        PruefungsRepository $pruefungsRepository,
        StudiPruefungDurchschnittPersistenzService $studiPruefungDurchschnittPersistenzService
    ) {
        $this->pruefungsRepository = $pruefungsRepository;
        $this->studiPruefungDurchschnittPersistenzService = $studiPruefungDurchschnittPersistenzService;
        parent::__construct();
    }

    protected function configure() {
        $this->setDescription('Berechnet alle Durchschnittswerte');
        $this->setHelp("Aufruf: bin/console l:i:studi <CSV-Dateipfad>");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $allePruefungen = $this->pruefungsRepository->all();
        foreach ($allePruefungen as $pruefung) {
            $this->studiPruefungDurchschnittPersistenzService
                ->berechneUndPersistiereDurchschnitt($pruefung->getId());
        }

    }

}