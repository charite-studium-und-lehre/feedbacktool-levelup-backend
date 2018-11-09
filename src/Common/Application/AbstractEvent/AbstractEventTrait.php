<?php

namespace Common\Application\AbstractEvent;

trait AbstractEventTrait
{
    /** @var \DateTimeImmutable */
    public $occurredOn;

    /** @var int */
    public $byUserId;

    public function getOccurredOn(): \DateTimeImmutable {
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
        $this->occurredOn = new \DateTimeImmutable();
    }
}