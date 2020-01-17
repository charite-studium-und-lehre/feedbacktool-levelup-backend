<?php

namespace Demo\Infrastructure\Persistence;

use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractJsonDemoData
{
    /** @var array */
    protected $jsonData;

    public function getController(): callable {
        return function() {
            return new JsonResponse($this->jsonData);
        };
    }
}