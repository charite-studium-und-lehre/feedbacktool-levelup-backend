<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use EPA\Domain\FremdBewertung\FremdBewertung;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsId;
use EPA\Domain\FremdBewertung\FremdBewertungsRepository;

final class FremdBewertungAbgebenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    /** @var FremdBewertungsAnfrageRepository */
    private $fremdBewertungsAnfrageRepository;

    /** @var FremdBewertungsRepository */
    private $fremdBewertungsRepository;

    public function __construct(
        FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository,
        FremdBewertungsRepository $fremdBewertungsRepository
    ) {
        $this->fremdBewertungsAnfrageRepository = $fremdBewertungsAnfrageRepository;
        $this->fremdBewertungsRepository = $fremdBewertungsRepository;
    }

    /** @param FremdBewertungAbgebenCommand $command */
    public function handle(DomainCommand $command): void {
        $fremdBewertungsAnfrage = $this->fremdBewertungsAnfrageRepository->byId(
            FremdBewertungsAnfrageId::fromInt($command->fremdBewertungsAnfrageId)
        );
        $epaBewertungen = [];
        foreach ($command->fremdBewertungen as $bewertungsArray) {
            $epaBewertungen[] =
                EPABewertung::fromValues($bewertungsArray["fremdbewertung"],
                                         EPA::fromInt($bewertungsArray["epaId"])
                );
        }
        if (!$epaBewertungen) {
            throw new \Exception("Es muss mindestens eine Bewertung abgegeben werden!");
        }
        $fremdBewertung = FremdBewertung::create(
            FremdBewertungsId::fromInt($command->fremdBewertungsId),
            $fremdBewertungsAnfrage->getLoginHash(),
            $fremdBewertungsAnfrage->getAnfrageDaten()->getAnfrageDatenOhneStudiInfo(),
            $epaBewertungen
        );

        $this->fremdBewertungsRepository->add($fremdBewertung);
        $this->fremdBewertungsRepository->flush();

    }

}
