<?php

namespace Common\Application;

interface CurrentUserIdService
{
    public function getUserId(): ?int;

}