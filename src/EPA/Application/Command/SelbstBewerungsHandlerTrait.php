<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
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
use Studi\Domain\LoginHash;

trait SelbstBewerungsHandlerTrait
{
    /**
     * @var SelbstBewertungsRepository
     */
    private $selbstBewertungsRepository;

    public function __construct(SelbstBewertungsRepository $selbstBewertungsRepository) {
        $this->selbstBewertungsRepository = $selbstBewertungsRepository;
    }

    /** @param SelbstBewertungErhoehenCommand $command */
    public function handle(DomainCommand $command): void {
        $loginHash = LoginHash::fromString($command->loginHash);
        $selbstBewertungsTyp = SelbstBewertungsTyp::fromInt($command->selbstBewertungsTyp);
        $epa = EPA::fromInt($command->epaId);

        $selbstBewertung = $this->selbstBewertungsRepository->latestByStudiUndTypUndEpa(
            $loginHash, $selbstBewertungsTyp, $epa
        );
        if ($selbstBewertung) {
            $this->aendereBewertung($selbstBewertung);
        } else {
            $neueBewertung = SelbstBewertung::create(
                $this->selbstBewertungsRepository->nextIdentity(),
                $loginHash,
                EPABewertung::fromValues(1, $epa),
                $selbstBewertungsTyp
            );
            $this->selbstBewertungsRepository->add($neueBewertung);
        }

        $this->selbstBewertungsRepository->flush();
    }
}