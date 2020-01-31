<?php

namespace Demo\Infrastructure\Persistence;

class EpasFremdBewertungenData extends AbstractJsonDemoData
{
    protected array $jsonData = [
        "fremdbewertungen" => [
            [
                "id"                  => 18,
                "name"                => "Lisa Simpson",
                "email"               => "lisa@simpson.de",
                "anfrageTaetigkeiten" => "",
                "anfrageKommentar"    => "",
                "datum"               => "2019-11-12",
            ],
            [
                "id"                  => 25,
                "name"                => "Indira Gandhi",
                "email"               => "indira@gandhi.de",
                "anfrageTaetigkeiten" => "",
                "anfrageKommentar"    => "",
                "datum"               => "2019-11-15",
            ],
            [
                "id"                  => 27,
                "name"                => "Madonna",
                "email"               => "madonna@charite.de",
                "anfrageTaetigkeiten" => "",
                "anfrageKommentar"    => "",
                "datum"               => "2019-11-19",
            ],
            [
                "id"                  => 31,
                "name"                => "Dr. Faustus",
                "email"               => "faustus@faustus.de",
                "anfrageTaetigkeiten" => "",
                "anfrageKommentar"    => "",
                "datum"               => "2020-01-24",
            ],
        ],
    ];

    public function isResponsibleFor(string $pathInfo): bool {
        return $pathInfo == "/api/epas/fremdbewertungen";
    }
}