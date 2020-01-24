<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use EPA\Application\Services\KontaktiereFremdBewerterService;

final class FremdBewertungAnfrageVerschickenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    private KontaktiereFremdBewerterService $kontaktiereFremdBewerterService;

    public function __construct(KontaktiereFremdBewerterService $kontaktiereFremdBewerterService) {
        $this->kontaktiereFremdBewerterService = $kontaktiereFremdBewerterService;
    }

    /** @param FremdBewertungAnfrageVerschickenCommand $command */
    public function handle(DomainCommand $command): void {
        $this->kontaktiereFremdBewerterService->run($command);
    }

}
