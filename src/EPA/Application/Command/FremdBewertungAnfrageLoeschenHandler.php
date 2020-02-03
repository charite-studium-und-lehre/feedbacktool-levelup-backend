<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use Exception;

final class FremdBewertungAnfrageLoeschenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    private FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository;

    public function __construct(FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository) {
        $this->fremdBewertungsAnfrageRepository = $fremdBewertungsAnfrageRepository;
    }

    /** @param FremdBewertungAnfrageLoeschenCommand $command */
    public function handle(DomainCommand $command): void {
        $anfrage = $this->fremdBewertungsAnfrageRepository->byId(
            FremdBewertungsAnfrageId::fromInt($command->fremdBewertungsAnfrageId)
        );
        if (!$anfrage) {
            throw new Exception("Anfrage zu Löschen wurde nicht gefunden!");
        }
        $this->fremdBewertungsAnfrageRepository->delete($anfrage);
        $this->fremdBewertungsAnfrageRepository->flush();
    }

}
