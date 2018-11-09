<?php

namespace Common\Infrastructure\Persistence\Common;

use Common\Application\AbstractEvent\StoredEvent;
use Common\Application\AbstractEvent\StoredEventId;
use Common\Application\AbstractEvent\StoredEventRepository;

abstract class AbstractSimpleStoredEventRepository extends AbstractCommonRepository implements StoredEventRepository
{

    public function byId(StoredEventId $idstoredEventId): ?StoredEvent {
        return $this->abstractById($idstoredEventId);
    }

    public function nextIdentity(): StoredEventId {
        return StoredEventId::fromInt($this->abstractNextIdentity()->getValue());
    }

}
