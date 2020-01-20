<?php

namespace Demo\Infrastructure\Persistence;

use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutData extends AbstractJsonDemoData
{
    public function getController(array $params = []): callable {
        return function() {
            return new RedirectResponse("/app-demo");
        };
    }

}