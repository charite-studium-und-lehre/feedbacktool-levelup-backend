<?php

namespace Common\Infrastructure\Persistence\InMemory;

use Common\Infrastructure\Persistence\Common\AbstractSimpleStoredEventRepository;
use Common\Infrastructure\Persistence\Common\InMemoryRepoTrait;

final class InMemorySimpleStoredEventRepository extends AbstractSimpleStoredEventRepository
{
    use InMemoryRepoTrait;
}