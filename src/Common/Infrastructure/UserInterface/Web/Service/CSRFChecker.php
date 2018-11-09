<?php

namespace Common\Infrastructure\UserInterface\Web\Service;

use LLPCommon\Infrastructure\UserInterface\Web\Service\LoggedInUserService;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CSRFChecker
{
    protected $csrfTokenManager;
    /** @var LoggedInUserService  */
    protected $loggedInUserService;

    public function __construct(CsrfTokenManagerInterface $tokenGeneratorcsrfTokenManager, LoggedInUserService $loggedInUserService) {
        $this->csrfTokenManager = $tokenGeneratorcsrfTokenManager;
        $this->loggedInUserService = $loggedInUserService;
    }

    public function generateToken(string $intention) : string {
        $token = $this->generateTokenObject($intention);
        return $token->getValue();
    }

    public function checkToken(string $intention, string $tokenString) {
        $token = $this->generateTokenObject($intention);
        return $token->getValue() == $tokenString;
    }

    private function generateTokenObject(string $intention) : CsrfToken {
        $tokenId = $this->getTokenString($intention);
        return $this->csrfTokenManager->getToken($tokenId);
    }


    private function getTokenString($intention) {
        return $intention
            . "_"
            . $this->loggedInUserService->getLoggedInPerson()->getId()->getValue();
    }


}