<?php

namespace Common\Infrastructure\Persistence\Common;

trait InMemoryRepoTrait
{
    protected $persistedEntities = [];

    public function all(): array {
        return $this->persistedEntities;
    }
}
