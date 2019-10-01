<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use EPA\Domain\EPABewertung;
use EPA\Domain\EPABewertungsDatum;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertungsTyp;
use Lehrberechtigung\Domain\Lehrberechtigung;
use Lehrberechtigung\Domain\LehrberechtigungRepository;
use Lehrberechtigung\Domain\LehrberechtigungsId;
use Lehrberechtigung\Domain\LehrberechtigungsTyp;
use Lehrberechtigung\Domain\LehrberechtigungsUmfang;
use Lehrberechtigung\Domain\Service\LehrberechtigungValidatorService;
use LLPCommon\Domain\Zeitsemester;
use Person\Domain\PersonId;
use Studi\Domain\StudiHash;

final class SelbstBewertungErhoehenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    /**
     * @var SelbstBewertungsRepository
     */
    private $selbstBewertungsRepository;

    public function __construct(SelbstBewertungsRepository $selbstBewertungsRepository) {
        $this->selbstBewertungsRepository = $selbstBewertungsRepository;
    }

    /** @param SelbstBewertungErhoehenCommand $command */
    public function handle(DomainCommand $command): void {
        $studiHash = StudiHash::fromString($command->studiHash);
        $selbstBewertungsTyp = SelbstBewertungsTyp::fromInt($command->selbstBewertungsTyp);

        $selbstBewertung = $this->selbstBewertungsRepository->latestByStudiUndTyp(
            $studiHash, $selbstBewertungsTyp
        );
        if ($selbstBewertung) {
            $selbstBewertung->erhoeheBewertung();
        } else {
            $neueBewertung = SelbstBewertung::create(
                $this->selbstBewertungsRepository->nextIdentity(),
                $studiHash,
                EPABewertung::fromInt(1),
                $selbstBewertungsTyp
            );
            $this->selbstBewertungsRepository->add($neueBewertung);
        }

        $this->selbstBewertungsRepository->flush();
    }

}
