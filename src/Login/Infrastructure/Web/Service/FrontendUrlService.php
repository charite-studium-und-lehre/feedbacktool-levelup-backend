<?php

declare(strict_types=1);

namespace Login\Infrastructure\Web\Service;

final class FrontendUrlService
{
    private $environment;

    public function __construct($environment) {
        $this->environment = $environment;
    }

    public function getFrontendUrl(): string {
        if ($this->environment == "production") {
            return "/app";
        }
        return "/app-develop";
    }

}