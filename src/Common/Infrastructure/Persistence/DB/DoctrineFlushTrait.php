<?php

namespace Common\Infrastructure\Persistence\DB;

trait DoctrineFlushTrait
{
    public function flush(): void {
        $this->entityManager->flush();
    }
}