<?php

namespace SSO\Infrastructure\Web\Service;

use Common\Domain\User\Username;
use Studi\Domain\LoginHash;
use Studi\Domain\Service\LoginHashCreator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserSwitcher {
    const SWITCHED_LOGIN_HASH_SESSION_KEY="switched_OriginalLoginHash";

    /** @var SessionInterface */
    private $session;

    /** @var LoginHashCreator */
    private $loginHashCreator;

    public function __construct(SessionInterface $session, LoginHashCreator $loginHashCreator) {
        $this->session = $session;
        $this->loginHashCreator = $loginHashCreator;
    }

    public function userIsSwiched(): bool {
        return $this->session->has(self::SWITCHED_LOGIN_HASH_SESSION_KEY);

    }

    public function setUserSwitched(Username $username): void {
        $loginHash = $this->loginHashCreator->createLoginHash($username);
        $this->session->set(self::SWITCHED_LOGIN_HASH_SESSION_KEY, $loginHash->getValue());
    }

    public function getSwitchedLoginHash(): ?LoginHash {
        $hash_string = $this->session->get(self::SWITCHED_LOGIN_HASH_SESSION_KEY);
        return $hash_string ? LoginHash::fromString($hash_string) : NULL;
    }

    public function unsetUserSwitched(): void {
        $this->session->remove(self::SWITCHED_LOGIN_HASH_SESSION_KEY, NULL);
    }



}
