<?php

namespace Common\Domain\Services;

interface CurrentUserIdService
{
    public function getUserId(): ?int;

}