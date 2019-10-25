<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
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

final class SelbstBewertungAendernHandler implements CommandHandler
{
    use CommandHandlerTrait;

    /**
     * @var SelbstBewertungsRepository
     */
    private $selbstBewertungsRepository;

    public function __construct(SelbstBewertungsRepository $selbstBewertungsRepository) {
        $this->selbstBewertungsRepository = $selbstBewertungsRepository;
    }

    /** @param SelbstBewertungAendernCommand $command */
    public function handle(DomainCommand $command): void {
        $loginHash = LoginHash::fromString($command->loginHash);
        $epa = EPA::fromInt($command->epaId);

        foreach ([SelbstBewertungsTyp::getGemachtObject(), SelbstBewertungsTyp::getZutrauenObject()]
            as $selbstBewertungsTyp) {
            /** @var SelbstBewertungsTyp $selbstBewertungsTyp */
            if ($selbstBewertungsTyp->istGemacht()) {
                $neuerWert = $command->gemacht;
            } else {
                $neuerWert = $command->zutrauen;
            }
            $selbstBewertung = $this->selbstBewertungsRepository->latestByStudiUndTypUndEpa(
                $loginHash, $selbstBewertungsTyp, $epa
            );
            if ($selbstBewertung) {
                $selbstBewertung->setzeBewertung($neuerWert);
            } else {
                $neueBewertung = SelbstBewertung::create(
                    $this->selbstBewertungsRepository->nextIdentity(),
                    $loginHash,
                    EPABewertung::fromValues($neuerWert, $epa),
                    $selbstBewertungsTyp
                );
                $this->selbstBewertungsRepository->add($neueBewertung);
            }
        }

        $this->selbstBewertungsRepository->flush();
    }

}
