<?php

namespace EPA\Domain\Service;

use EPA\Domain\FremdBewertung\FremdBewertung;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageDaten;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsRepository;
use EPA\Domain\SelbstBewertung\SelbstBewertung;
use EPA\Domain\SelbstBewertung\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertung\SelbstBewertungsTyp;
use Studi\Domain\LoginHash;

class EpasFuerStudiService
{
    /** @var SelbstBewertungsRepository */
    private $selbstBewertungsRepository;

    /** @var FremdBewertungsAnfrageRepository */
    private $fremdBewertungsAnfrageRepository;

    /** @var FremdBewertungsRepository */
    private $fremdBewertungsRepository;

    public function __construct(
        SelbstBewertungsRepository $selbstBewertungsRepository,
        FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository,
        FremdBewertungsRepository $fremdBewertungsRepository
    ) {
        $this->selbstBewertungsRepository = $selbstBewertungsRepository;
        $this->fremdBewertungsAnfrageRepository = $fremdBewertungsAnfrageRepository;
        $this->fremdBewertungsRepository = $fremdBewertungsRepository;
    }

    /** Erzeugt die Struktur wie im ZIM für das Frontend dokumentiert. */
    public function getEpaStudiData(LoginHash $loginHash) {
        $bewertungenZutrauen = $this->selbstBewertungsRepository->allLatestByStudiUndTyp(
            $loginHash, SelbstBewertungsTyp::getZutrauenObject()
        );
        $bewertungenGemacht = $this->selbstBewertungsRepository->allLatestByStudiUndTyp(
            $loginHash, SelbstBewertungsTyp::getGemachtObject()
        );
        $bewertungsArrays = ["zutrauen" => $bewertungenZutrauen, "gemacht" => $bewertungenGemacht];
        $bewertungenNachId = [];

        foreach ($bewertungsArrays as $typ => $selbstBewertungen) {
            foreach ($selbstBewertungen as $selbstBewertung) {
                /** @var $selbstBewertung SelbstBewertung */
                $bewertungenNachId[$selbstBewertung->getEpaBewertung()->getEpa()->getNummer()][$typ]
                    = $selbstBewertung->getEpaBewertung()->getBewertungInt();
            }
        }

        $alleBewertungen = [];

        $fremdBewertungen = $this->fremdBewertungsRepository->allByStudi($loginHash);
        foreach ($fremdBewertungen as $fremdBewertung) {
            $fremdBewertungsId = $fremdBewertung->getId();
            foreach ($fremdBewertung->getBewertungen() as $bewertung) {
                $bewertungenNachId[$bewertung->getEpa()->getNummer()]["fremdbewertungen"][] =
                    [
                        "fremdbewertungsId" => $fremdBewertungsId->getValue(),
                        "wert" => $bewertung->getBewertungInt()
                    ];
            }
        }

        foreach ($bewertungenNachId as $epaId => $bewertung) {
            $alleBewertungen[] = [
                "epaId"    => $epaId,
                "gemacht"  => $bewertungenNachId[$epaId]["gemacht"] ?? NULL,
                "zutrauen" => $bewertungenNachId[$epaId]["zutrauen"] ?? NULL,
                "fremdbewertungen" => $bewertungenNachId[$epaId]["fremdbewertungen"] ?? NULL,
            ];
        }

        return ["bewertungen" => $alleBewertungen];

    }

    /**
     * @param LoginHash $loginHash
     * @return array
     */
    public function getFremdBewertungen(LoginHash $loginHash): array {
        $anfragen = $this->fremdBewertungsAnfrageRepository->allByStudi($loginHash);
        $returnArray = [];
        foreach ($anfragen as $anfrage) {
            $bewertungsArray = ["id" => "Anfrage" . $anfrage->getId()->getValue()];
            $bewertungsArray += $this->bewertungsDatenAusAnfrageDaten($anfrage->getAnfrageDaten());
            $bewertungsArray["status"] = "offen";
            $returnArray[] = $bewertungsArray;
        }
        $fremdbewertungen = $this->fremdBewertungsRepository->allByStudi($loginHash);
        foreach ($fremdbewertungen as $fremdbewertung) {
            $bewertungsArray = ["id" => $fremdbewertung->getId()->getValue()];
            $bewertungsArray += $this->bewertungsDatenAusAnfrageDaten($fremdbewertung->getAnfrageDaten());
            $bewertungsArray["status"] = "beantwortet";
            $returnArray[] = $bewertungsArray;
        }

        return $returnArray;
    }

    public function bewertungsDatenAusAnfrageDaten(FremdBewertungsAnfrageDaten $anfrageDaten): array {
        return [
            "name"                => $anfrageDaten->getFremdBerwerterName()->getValue(),
            "email"               => $anfrageDaten->getFremdBerwerterEmail()->getValue(),
            "anfrageTaetigkeiten" => $anfrageDaten->getAnfrageTaetigkeiten() . "",
            "anfrageKommentar"    => $anfrageDaten->getAnfrageKommentar() . "",
            "datum"               => $anfrageDaten->getDatum()->toIsoString(),
            "status"              => "offen",
        ];

        return $returnArray;
    }

    public function getFremdBewertungAnfrageDaten(FremdBewertungsAnfrage $anfrage): array {
        $taetigkeiten = $anfrage->getAnfrageDaten()->getAnfrageTaetigkeiten() . "";
        $kommentar = $anfrage->getAnfrageDaten()->getAnfrageKommentar() . "";

        return [
            "id"                  => NULL,
            "name"                => $anfrage->getAnfrageDaten()
                ->getFremdBerwerterName()->getValue(),
            "email"               => $anfrage->getAnfrageDaten()
                ->getFremdBerwerterEmail()->getValue(),
            "anfrageTaetigkeiten" => $taetigkeiten,
            "anfrageKommentar"    => $kommentar,
            "datum"               => $anfrage->getAnfrageDaten()->getDatum()->toIsoString(),
            "status"              => "offen",
        ];

        return $returnArray;
    }



    /**
     * @param LoginHash $loginHash
     * @return array
     */
    private function getSelbstBewertungen(LoginHash $loginHash, SelbstBewertungsTyp $typ): array {
        $bewertungen = $this->selbstBewertungsRepository->allLatestByStudiUndTyp($loginHash, $typ);

        return $this->selbstBewertungsListeZuIdWertung($bewertungen);
    }

    /** @param SelbstBewertung[] $selbstbewertungen */
    private function selbstBewertungsListeZuIdWertung(array $selbstbewertungen) {
        $returnArray = [];
        foreach ($selbstbewertungen as $einzelSelbstBewertung) {
            $bewertung = $einzelSelbstBewertung->getEpaBewertung();
            $returnArray[$bewertung->getEpa()->getNummer()] = $bewertung->getBewertungInt();
        }

        return $returnArray;
    }

}