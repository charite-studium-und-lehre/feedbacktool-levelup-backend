<?php

namespace Common\Infrastructure\Persistence\Common;

trait InMemoryRepoTrait
{
    protected $persistedEntities = [];

    public function getAll(): array {
        return $this->persistedEntities;
    }
}
