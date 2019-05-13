<?php

namespace Studi\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiIntern;
use Studi\Domain\StudiInternRepository;

final class StudiInternHinzufuegenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    /** @var StudiInternRepository */
    private $studiInternRepository;

    public function __construct(StudiInternRepository $studiInternRepository) {
        $this->studiInternRepository = $studiInternRepository;
    }

    /**
     * @param StudiInternHinzufuegenCommand $command
     */
    public function handle(DomainCommand $command): void {

        $matrikelnummer = Matrikelnummer::fromInt($command->matrikelnummer);
        $studiHash = StudiHash::fromString($command->studiHash);
        $studiIntern = StudiIntern::fromMatrikelUndStudiHash($matrikelnummer, $studiHash);
        $this->studiInternRepository->add($studiIntern);
        $this->studiInternRepository->flush();
    }

}
