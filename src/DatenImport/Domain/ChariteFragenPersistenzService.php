<?php

namespace DatenImport\Domain;

use Pruefung\Domain\FrageAntwort\Antwort;
use Pruefung\Domain\FrageAntwort\AntwortCode;
use Pruefung\Domain\FrageAntwort\AntwortId;
use Pruefung\Domain\FrageAntwort\AntwortRepository;
use Pruefung\Domain\FrageAntwort\Frage;
use Pruefung\Domain\FrageAntwort\FragenId;
use Pruefung\Domain\FrageAntwort\FragenRepository;
use Pruefung\Domain\PruefungsItemId;

class ChariteFragenPersistenzService
{
    private FragenRepository $fragenRepository;

    private AntwortRepository $antwortRepository;

    public function __construct(FragenRepository $fragenRepository, AntwortRepository $antwortRepository) {
        $this->fragenRepository = $fragenRepository;
        $this->antwortRepository = $antwortRepository;
    }

    /** @param ChariteFragenDTO[] $fragenDTOs */
    public function persistiereFragenUndAntworten(array $fragenDTOs): void {
        foreach ($fragenDTOs as $fragenDTO) {
            $pruefungsItemId = PruefungsItemId::fromPruefungsIdUndFragenNummer(
                $fragenDTO->pruefungsId, $fragenDTO->fragenNr
            );
            $fragenId = FragenId::fromPruefungItemIdUndFragenNummer(
                $pruefungsItemId, $fragenDTO->fragenNr
            );
            $frage = $this->fragenRepository->byId($fragenId);
            if ($frage) {
                $frage->setFragenNummer($fragenDTO->fragenNr);
                $frage->setFragenText($fragenDTO->fragenText);
            } else {
                $frage = Frage::fromPruefungsItemIdUndFrage(
                    $fragenId,
                    $pruefungsItemId,
                    $fragenDTO->fragenNr,
                    $fragenDTO->fragenText,
                    );
                $this->fragenRepository->add($frage);
            }

            $existierendeAntworten = $this->antwortRepository->allByFragenId($fragenId);
            $existierendeAntwortCodes = [];
            foreach ($existierendeAntworten as $neueAntwort) {
                $existierendeAntwortCodes[$neueAntwort->getAntwortCode()->getValue()] = $neueAntwort;
            }

            foreach ($fragenDTO->antworten as $antwortCodeString => $antwortText) {
                $antwortCode = AntwortCode::fromString($antwortCodeString);
                $istRichtig = $antwortCode->equals($fragenDTO->loesung);
                if (isset($existierendeAntwortCodes[$antwortCode->getValue()])) {
                    /** @var Antwort $existierendeAntwort */
                    $existierendeAntwort = $existierendeAntwortCodes[$antwortCode->getValue()];
                    $existierendeAntwort->setAntwortText($antwortText);
                    $existierendeAntwort->setIstRichtig($istRichtig);
                    unset($existierendeAntwortCodes[$antwortCode->getValue()]);
                } else {
                    $neueAntwort = Antwort::fromPruefungsItemIdUndFragenId(
                        AntwortId::fromFragenIdUndCode($fragenId, $antwortCode),
                        $fragenId,
                        $antwortCode,
                        $antwortText,
                        $istRichtig
                    );
                    $this->antwortRepository->add($neueAntwort);
                }
            }
            foreach ($existierendeAntwortCodes as $zuLoeschendeAntwort) {
                $this->antwortRepository->delete($zuLoeschendeAntwort);
            }

        }
        $this->fragenRepository->flush();
        $this->antwortRepository->flush();
    }
}
