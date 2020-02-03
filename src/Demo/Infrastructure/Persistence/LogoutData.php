<?php

namespace Demo\Infrastructure\Persistence;

use Symfony\Component\HttpFoundation\RedirectResponse;

class LogoutData extends AbstractJsonDemoData
{
    public function getController(string $pathInfo): callable {
        return fn() => new RedirectResponse("/app-demo");
    }

    public function isResponsibleFor(string $pathInfo): bool {
        return $pathInfo == "/logout"
            || $pathInfo == "/logoutFromSSO";
    }
}