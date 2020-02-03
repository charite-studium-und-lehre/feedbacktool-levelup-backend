<?php

namespace Demo\Infrastructure\Persistence;

class EpasFremdBewertungsAnfragenData extends AbstractJsonDemoData
{
    protected array $jsonData = [
        "fremdbewertungsAnfragen" => [
            [
                "id"                  => 51,
                "name"                => "March Simpson",
                "email"               => "mdi@posteo.de",
                "anfrageTaetigkeiten" => "",
                "anfrageKommentar"    => "Gelbsucht",
                "datum"               => "2019-11-13",
            ],
        ],
    ];

    public function isResponsibleFor(string $pathInfo): bool {
        return $pathInfo == "/api/epas/fremdbewertungen/anfragen";
    }
}