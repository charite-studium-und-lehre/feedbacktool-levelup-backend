<?php

namespace Common\Application\AbstractEvent;

use Common\Domain\FlushableRepository;

interface StoredEventRepository extends FlushableRepository
{
    public function add(StoredEvent $storedEvent);

    public function byId(StoredEventId $idstoredEventId): ?StoredEvent;

    public function all(): array;

    public function nextIdentity(): StoredEventId;
}