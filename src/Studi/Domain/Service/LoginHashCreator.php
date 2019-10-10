<?php

namespace Studi\Domain\Service;

use Common\Domain\User\Username;
use Studi\Domain\LoginHash;

interface LoginHashCreator
{
    public function __construct(string $appSecret);

    public function createLoginHash(
        Username $username
    ): LoginHash;

    public function isCorrectLoginHash(
        LoginHash $loginHash,
        Username $username
    ): bool;

}