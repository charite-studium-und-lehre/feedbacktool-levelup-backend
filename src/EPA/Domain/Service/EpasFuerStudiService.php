<?php

namespace EPA\Domain\Service;

use EPA\Domain\EPAKategorie;
use EPA\Domain\SelbstBewertung;
use EPA\Domain\SelbstBewertungsRepository;
use EPA\Domain\SelbstBewertungsTyp;
use Studi\Domain\LoginHash;

class EpasFuerStudiService
{
    /** @var SelbstBewertungsRepository */
    private $selbstBewertungsRepository;

    public function __construct(SelbstBewertungsRepository $selbstBewertungsRepository) {
        $this->selbstBewertungsRepository = $selbstBewertungsRepository;
    }

    /** Erzeugt die Sturktur wie im ZIM für das Frontend dokumentiert. */
    public function getEpaStudiData(LoginHash $loginHash) {
        $gemachtArray = $this->getSelbstEinschaetzungen($loginHash, SelbstBewertungsTyp::getGemachtObject());
        $zutrauenArray = $this->getSelbstEinschaetzungen($loginHash, SelbstBewertungsTyp::getZutrauenObject());
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
            "fremdeinschaetzungen" => [],
        ];

    }

    /**
     * @param LoginHash $loginHash
     * @return array
     */
    private function getSelbstEinschaetzungen(LoginHash $loginHash, SelbstBewertungsTyp $typ): array {
        $bewertungen = $this->selbstBewertungsRepository->allLatestByStudiUndTyp($loginHash, $typ);

        return $this->selbstBewertungsListeZuIdWertung($bewertungen);
    }

    /** @param SelbstBewertung[] $selbstbewertungen */
    private function selbstBewertungsListeZuIdWertung(array $selbstbewertungen) {
        $returnArray = [];
        foreach ($selbstbewertungen as $einzelSelbstBewertung) {
            $bewertung = $einzelSelbstBewertung->getEpaBewertung();
            $returnArray[$bewertung->getEpa()->getNummer()] = $bewertung->getBewertung();
        }

        return $returnArray;
    }

}