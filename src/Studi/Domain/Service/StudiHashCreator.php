<?php

namespace Studi\Domain\Service;

use Studi\Domain\StudiData;
use Studi\Domain\StudiHash;

interface StudiHashCreator
{
    public function __construct(string $appSecret);

    public function createStudiHash(
        StudiData $studiData
    ): StudiHash;

    public function isCorrectStudiHash(
        StudiHash $studiHash,
        StudiData $studiData
    ): bool;

}