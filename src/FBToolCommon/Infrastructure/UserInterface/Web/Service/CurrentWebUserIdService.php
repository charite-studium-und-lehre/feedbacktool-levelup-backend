<?php

namespace FBToolCommon\Infrastructure\UserInterface\Web\Service;

use Common\Domain\Services\CurrentUserIdService;

class CurrentWebUserIdService implements CurrentUserIdService
{
    public function getUserId(): ?int {
        return 0;
    }

}