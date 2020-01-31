<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use EPA\Application\Services\KontaktiereStudiUeberFremdbewertungService;

final class StudiUeberFremdbewertungInformierenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    private KontaktiereStudiUeberFremdbewertungService $kontaktiereStudiUeberFremdbewertungService;

    public function __construct(KontaktiereStudiUeberFremdbewertungService $kontaktiereStudiUeberFremdbewertungService
    ) {
        $this->kontaktiereStudiUeberFremdbewertungService = $kontaktiereStudiUeberFremdbewertungService;
    }

    /** @param StudiUeberFremdbewertungInformierenCommand $command */
    public function handle(DomainCommand $command): void {
        $this->kontaktiereStudiUeberFremdbewertungService->run($command);
    }

}
