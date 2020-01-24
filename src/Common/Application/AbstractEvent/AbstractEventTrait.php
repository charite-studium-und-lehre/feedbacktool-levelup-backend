<?php

namespace Common\Application\AbstractEvent;

use DateTimeImmutable;

trait AbstractEventTrait
{
    public \DateTimeImmutable $occurredOn;

    public int $byUserId;

    public function getOccurredOn(): DateTimeImmutable {
        return $this->occurredOn;
    }

    public function getByUserId(): int {
        return $this->byUserId;
    }

    public function setInitialValues(?int $byUserId): void {
        $this->byUserId = $byUserId;
        $this->setOccuredOn();
    }

    private function setOccuredOn() {
        $this->occurredOn = new DateTimeImmutable();
    }
}