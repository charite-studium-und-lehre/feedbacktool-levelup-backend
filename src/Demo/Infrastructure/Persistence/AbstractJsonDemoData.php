<?php

namespace Demo\Infrastructure\Persistence;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractJsonDemoData
{
    /** @var array */
    protected $jsonData;

    public function getController(string $pathInfo): callable {
        return function() {
            return new JsonResponse($this->jsonData);
        };
    }

    abstract public function isResponsibleFor(string $pathInfo): bool;
}