<?php

namespace Demo\Infrastructure\Persistence;

class StammdatenJsonDemoData extends AbstractJsonDemoData
{
    protected array $jsonData = [
        'vorname'             => 'Demo',
        'nachname'            => 'Tester',
        'email'               => 'demo.tester@charite.de',
        'stammdatenVorhanden' => TRUE,
        'istAdmin'            => FALSE,
    ];

    public function isResponsibleFor(string $pathInfo): bool {
        return $pathInfo == "/api/stammdaten";
    }
}