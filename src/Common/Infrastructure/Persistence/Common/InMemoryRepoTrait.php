<?php

namespace Common\Infrastructure\Persistence\Common;

trait InMemoryRepoTrait
{
    public function all(): array {
        return $this->persistedEntities;
    }
}
