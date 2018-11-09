<?php

namespace LLPCommon\Infrastructure\UserInterface\Web\Service;

use Common\Application\CurrentUserIdService;

class CurrentWebUserIdService implements CurrentUserIdService
{
    /** @var LoggedInUserService */
    private $loggedInUserService;

    public function __construct(LoggedInUserService $loggedInUserService) {
        $this->loggedInUserService = $loggedInUserService;
    }

    public function getUserId(): ?int {
        return $this->loggedInUserService->getLoggedInPerson()->getId()->getValue();
    }

}