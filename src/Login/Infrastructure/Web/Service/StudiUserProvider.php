<?php

namespace Login\Infrastructure\Web\Service;

use Common\Domain\User\LoginUser;
use Common\Infrastructure\UserInterface\Web\Service\ChariteLDAPService;
use Common\Infrastructure\UserInterface\Web\Service\ChariteLDAPUserProvider;
use Exception;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class StudiUserProvider extends ChariteLDAPUserProvider
{
    private StudiRepository $studiRepository;

    private UserSwitcher $userSwitcher;

    public function __construct(
        StudiRepository $studiRepository,
        UserSwitcher $userSwitcher,
        ChariteLDAPService $chariteLDAPService
    ) {
        parent::__construct($chariteLDAPService);
        $this->studiRepository = $studiRepository;
        $this->userSwitcher = $userSwitcher;
    }

    /**
     * Loads the user for the given username.
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     * @return UserInterface
     * @throws UsernameNotFoundException if the user is not found
     */

    public function loadUserByUsername($username): ?LoginUser {
        $usernameExploded = explode("^", $username);
        $loginUsername = $usernameExploded[0];
        $loginUser = parent::loadUserByUsername($loginUsername);
        if (!$loginUser) {
            throw new Exception("User im LDAP nicht gefunden");
        }

        $studiHash = count($usernameExploded) > 1 ? $usernameExploded[1] : NULL;
        if (!$studiHash) {
            return $loginUser;
        }
        $studi = $this->studiRepository->byStudiHash(StudiHash::fromString($studiHash));
        if ($this->userSwitcher->userIsSwiched()) {
            $studi = clone $studi;
            // setze LoginHash nicht auf von Doctrine verwaltetem Studi
            $studi->setLoginHash($this->userSwitcher->getSwitchedLoginHash());
        }
        $studi = $studi->macheZuLoginUser($loginUser);

        return $studi;

    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     * @return bool
     */
    public function supportsClass($class) {
        return TRUE;

        return $class === Studi::class || $class === LoginUser::class;
    }
}