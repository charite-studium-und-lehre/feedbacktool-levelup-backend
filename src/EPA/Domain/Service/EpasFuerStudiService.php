<?php

namespace EPA\Domain\Service;

use EPA\Domain\EPAKategorie;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
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

    public function __construct(
        SelbstBewertungsRepository $selbstBewertungsRepository,
        FremdBewertungsAnfrageRepository $fremdBewertungsAnfrageRepository
    ) {
        $this->selbstBewertungsRepository = $selbstBewertungsRepository;
        $this->fremdBewertungsAnfrageRepository = $fremdBewertungsAnfrageRepository;
    }

    /** Erzeugt die Struktur wie im ZIM für das Frontend dokumentiert. */
    public function getEpaStudiData(LoginHash $loginHash) {
        $gemachtArray = $this->getSelbstBewertungen($loginHash, SelbstBewertungsTyp::getGemachtObject());
        $zutrauenArray = $this->getSelbstBewertungen($loginHash, SelbstBewertungsTyp::getZutrauenObject());
        $epaStruktur = EPAKategorie::getEPAStrukturFlach();

        $meineEPAs = [];
        foreach ($epaStruktur as $epaElement) {
            $gemacht = NULL;
            $zutrauen = NULL;
            if ($epaElement->istBlatt()) {
                $gemacht =
                    isset($gemachtArray[$epaElement->getNummer()]) ? $gemachtArray[$epaElement->getNummer()] : NULL;
                $zutrauen =
                    isset($zutrauenArray[$epaElement->getNummer()]) ? $zutrauenArray[$epaElement->getNummer()] : NULL;
            }
            $meineEPAs[] = [
                "id"           => $epaElement->getNummer(),
                "beschreibung" => $epaElement->getBeschreibung(),
                "parentId"     => $epaElement->getParent() ? $epaElement->getParent()->getNummer() : NULL,
                "istBlatt"     => $epaElement->istBlatt(),
                "gemacht"      => $gemacht,
                "zutrauen"     => $zutrauen,
            ];
        }

        return [
            "meineEPAs"            => $meineEPAs,
            "fremdbewertungen" => $this->getFremdBewertungen($loginHash),
        ];

    }

    /**
     * @param LoginHash $loginHash
     * @return array
     */
    private function getFremdBewertungen(LoginHash $loginHash): array {
        $anfragen = $this->fremdBewertungsAnfrageRepository->allByStudi($loginHash);
        $returnArray = [];
        foreach ($anfragen as $anfrage) {
            $returnArray[] = $this->getFremdBewertungAnfrageData($anfrage, $returnArray);
        }

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

    public function getFremdBewertungAnfrageData(FremdBewertungsAnfrage $anfrage): array {
        $taetigkeiten = $anfrage->getFremdBewertungsAnfrageDaten()->getFremdBewertungsAnfrageTaetigkeiten()
            ? $anfrage->getFremdBewertungsAnfrageDaten()->getFremdBewertungsAnfrageTaetigkeiten()->getValue()
            : NULL;
        $kommentar = $anfrage->getFremdBewertungsAnfrageDaten()->getFremdBewertungsAnfrageKommentar()
            ? $anfrage->getFremdBewertungsAnfrageDaten()->getFremdBewertungsAnfrageKommentar()->getValue()
            : NULL;
        return [
            "id"                  => NULL,
            "name"                => $anfrage->getFremdBewertungsAnfrageDaten()
                ->getFremdBerwerterName()->getValue(),
            "email"               => $anfrage->getFremdBewertungsAnfrageDaten()
                ->getFremdBerwerterEmail()->getValue(),
            "anfrageTaetigkeiten" => $taetigkeiten,
            "anfrageKommentar"    => $kommentar,
            "datum"               => $anfrage->getFremdBewertungsAnfrageDaten()->getDatum()->toIsoString(),
            "status"              => "offen",
        ];

        return $returnArray;
    }

}