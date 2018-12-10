<?php

namespace Common\Infrastructure\UserInterface\Web\Service;

use Common\Domain\Services\CurrentUserIdService;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CSRFChecker
{
    protected $csrfTokenManager;

    /** @var CurrentUserIdService */
    protected $currentUserIdService;

    public function __construct(CsrfTokenManagerInterface $tokenGeneratorcsrfTokenManager, CurrentUserIdService
    $currentUserIdService) {
        $this->csrfTokenManager = $tokenGeneratorcsrfTokenManager;
        $this->currentUserIdService = $currentUserIdService;
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
            . $this->currentUserIdService->getUserId();
    }


}