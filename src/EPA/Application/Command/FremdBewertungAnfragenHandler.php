<?php

namespace EPA\Application\Command;

use Common\Application\Command\DomainCommand;
use Common\Application\CommandHandler\CommandHandler;
use Common\Application\CommandHandler\CommandHandlerTrait;
use Common\Domain\User\Email;
use EPA\Domain\FremdBewertung\AnfragerName;
use EPA\Domain\FremdBewertung\FremdBewerterName;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageDaten;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageKommentar;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageTaetigkeiten;
use Studi\Domain\LoginHash;

final class FremdBewertungAnfragenHandler implements CommandHandler
{
    use CommandHandlerTrait;

    /** @var FremdBewertungsAnfrageRepository */
    private $fremdBewertungsAnfrageRepository;

    public function __construct(FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository) {
        $this->fremdBewertungsAnfrageRepository = $fremdBewertungsAnfrageRepository;
    }

    /** @param FremdBewertungAnfragenCommand $command */
    public function handle(DomainCommand $command): void {
        $loginHash = LoginHash::fromString($command->loginHash);
        $taetigkeiten = $command->angefragteTaetigkeiten
            ? FremdBewertungsAnfrageTaetigkeiten::fromString($command->angefragteTaetigkeiten)
            : NULL;
        $kommentar = $command->kommentar
            ? FremdBewertungsAnfrageKommentar::fromString($command->kommentar)
            : NULL;
        $fremdBewertungsAnfrageDaten = FremdBewertungsAnfrageDaten::fromDaten(
            FremdBewerterName::fromString($command->fremdBewerterName),
            Email::fromString($command->fremdBewerterEmail),
            AnfragerName::fromString($command->studiName),
            Email::fromString($command->studiEmail),
            $taetigkeiten,
            $kommentar
        );
        $fremdBewertungsAnfrage = FremdBewertungsAnfrage::create(
            FremdBewertungsAnfrageId::fromInt($command->fremdBewertungsAnfrageId),
            $loginHash,
            $fremdBewertungsAnfrageDaten
        );
        $this->fremdBewertungsAnfrageRepository->add($fremdBewertungsAnfrage);
        $this->fremdBewertungsAnfrageRepository->flush();

    }

}
