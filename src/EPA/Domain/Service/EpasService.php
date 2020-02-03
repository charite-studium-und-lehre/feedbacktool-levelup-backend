<?php

namespace EPA\Domain\Service;

use EPA\Domain\EPAKategorie;

class EpasService
{
    /**
     * Erzeugt die Struktur wie im ZIM für das Frontend dokumentiert.
     *
     * @return Array<Array<string, string>>
     */
    public function getAlleEPAs(): array {
        $epaStruktur = EPAKategorie::getEPAStrukturFlach();

        $epas = [];
        foreach ($epaStruktur as $epaElement) {
            $epas[] = [
                "id"           => $epaElement->getNummer(),
                "beschreibung" => $epaElement->getBeschreibung(),
                "parentId"     => $epaElement->getParent() ? $epaElement->getParent()->getNummer() : NULL,
                "istBlatt"     => $epaElement->istBlatt(),
            ];
        }

        return [
            "epas" => $epas,
        ];
    }
}