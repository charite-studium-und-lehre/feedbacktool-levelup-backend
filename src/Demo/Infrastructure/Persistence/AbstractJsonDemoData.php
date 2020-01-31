<?php

namespace Demo\Infrastructure\Persistence;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractJsonDemoData
{
    protected array $jsonData;

    public function getController(string $pathInfo): callable {
        return fn() => new JsonResponse($this->jsonData);
    }

    abstract public function isResponsibleFor(string $pathInfo): bool;
}