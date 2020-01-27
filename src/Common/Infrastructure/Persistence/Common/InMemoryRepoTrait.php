<?php

namespace Common\Infrastructure\Persistence\Common;

use Common\Domain\DDDEntity;

trait InMemoryRepoTrait
{
    /** @return DDDEntity[] */
    public function all(): array {
        return $this->persistedEntities;
    }
}
