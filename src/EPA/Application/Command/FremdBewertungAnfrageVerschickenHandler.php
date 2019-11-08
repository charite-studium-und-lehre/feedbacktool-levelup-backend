<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use Common\Domain\User\Email;
use EPA\Application\Services\KontaktiereFremdBewerterService;
use EPA\Domain\FremdBewertung\AnfragerName;
use EPA\Domain\FremdBewertung\FremdBewerterName;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageDaten;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageKommentar;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageTaetigkeiten;
use Studi\Domain\LoginHash;

final class FremdBewertungAnfrageVerschickenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    /** @var KontaktiereFremdBewerterService */
    private $kontaktiereFremdBewerterService;

    public function __construct(KontaktiereFremdBewerterService $kontaktiereFremdBewerterService) {
        $this->kontaktiereFremdBewerterService = $kontaktiereFremdBewerterService;
    }

    /** @param FremdBewertungAnfrageVerschickenCommand $command */
    public function handle(DomainCommand $command): void {
        $this->kontaktiereFremdBewerterService->run($command);
    }

}
