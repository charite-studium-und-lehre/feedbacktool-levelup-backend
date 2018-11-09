<?php

namespace Common\Domain;

interface FlushableRepository
{
    /**
     * Flush all changed entities already known by Repository
     */
    public function flush(): void;
}