<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use Common\Domain\User\Email;
use EPA\Domain\FremdBewertung\AnfragerName;
use EPA\Domain\FremdBewertung\FremdBewerterName;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageDaten;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageKommentar;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageTaetigkeiten;
use Studi\Domain\LoginHash;

final class FremdBewertungAnfrageLoeschenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    /** @var FremdBewertungsAnfrageRepository */
    private $fremdBewertungsAnfrageRepository;

    public function __construct(FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository) {
        $this->fremdBewertungsAnfrageRepository = $fremdBewertungsAnfrageRepository;
    }

    /** @param FremdBewertungAnfrageLoeschenCommand $command */
    public function handle(DomainCommand $command): void {
        $anfrage = $this->fremdBewertungsAnfrageRepository->byId(
            FremdBewertungsAnfrageId::fromInt($command->fremdBewertungsAnfrageId)
        );
        if (!$anfrage) {
            throw new \Exception("Anfrage zu Löschen wurde nicht gefunden!");
        }
        $this->fremdBewertungsAnfrageRepository->delete($anfrage);
        $this->fremdBewertungsAnfrageRepository->flush();
    }

}
