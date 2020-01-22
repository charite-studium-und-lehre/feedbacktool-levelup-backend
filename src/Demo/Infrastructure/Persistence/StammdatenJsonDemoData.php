<?php

namespace Demo\Infrastructure\Persistence;

class StammdatenJsonDemoData extends AbstractJsonDemoData
{
    protected $jsonData = [
        'vorname' => 'Demo',
        'nachname' => 'Tester',
        'email' => 'demo.tester@charite.de',
        'stammdatenVorhanden' => true,
        'istAdmin' => false,
    ];

    public function isResponsibleFor(string $pathInfo): bool {
        return $pathInfo == "/api/stammdaten";
    }
}