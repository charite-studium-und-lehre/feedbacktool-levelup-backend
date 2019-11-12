<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use EPA\Application\Services\KontaktiereStudiUeberFremdbewertungService;

final class StudiUeberFremdbewertungInformierenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    /** @var KontaktiereStudiUeberFremdbewertungService */
    private $kontaktiereStudiUeberFremdbewertungService;

    public function __construct(KontaktiereStudiUeberFremdbewertungService $kontaktiereStudiUeberFremdbewertungService
    ) {
        $this->kontaktiereStudiUeberFremdbewertungService = $kontaktiereStudiUeberFremdbewertungService;
    }

    /** @param StudiUeberFremdbewertungInformierenHandler $command */
    public function handle(DomainCommand $command): void {
        $this->kontaktiereStudiUeberFremdbewertungService->run($command);
    }

}
