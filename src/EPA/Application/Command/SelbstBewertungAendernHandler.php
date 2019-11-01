<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use EPA\Domain\EPABewertungsDatum;
use EPA\Domain\SelbstBewertung\SelbstBewertung;
use EPA\Domain\SelbstBewertung\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertung\SelbstBewertungsTyp;
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
            /** @var \EPA\Domain\SelbstBewertung\SelbstBewertungsTyp $selbstBewertungsTyp */
            if ($selbstBewertungsTyp->istGemacht()) {
                $neuerWert = $command->gemacht;
            } else {
                $neuerWert = $command->zutrauen;
            }
            $selbstBewertung = $this->selbstBewertungsRepository->latestByStudiUndTypUndEpa(
                $loginHash, $selbstBewertungsTyp, $epa
            );
            if ($selbstBewertung
                && !$selbstBewertung->getEpaBewertungsDatum()->equals(EPABewertungsDatum::heute())
            ) {
                $selbstBewertung = NULL;
            }
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
