<?php

namespace Common\Infrastructure\UserInterface\Web\Service;

use Common\Domain\User\LoginUser;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ChariteLDAPUserProvider implements UserProviderInterface
{

    private ChariteLDAPService $chariteLDAPService;
    /** @var array<string>  */
    private array $adminUserNames = [];

    public function __construct(ChariteLDAPService $chariteLDAPService, ?string $adminUserNames = null) {

        $this->chariteLDAPService = $chariteLDAPService;
        $this->adminUserNames = json_decode($adminUserNames, FALSE) ?? [];
    }


    /**
     * Loads the user for the given username.
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     * @return UserInterface
     */

    public function loadUserByUsername($username): ?LoginUser {
        $loginUser = $this->chariteLDAPService->getLoginUserByUsername($username);
        if (!$loginUser) {
            return NULL;
        }
        if (in_array($loginUser->getUsername(), $this->adminUserNames)) {
            $loginUser = $loginUser->macheZuAdmin();
        }

        return $loginUser;
    }

    /**
     * Refreshes the user.
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     * @throws UnsupportedUserException  if the user is not supported
     */
    public function refreshUser(UserInterface $user) {
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     * @return bool
     */
    public function supportsClass($class) {
        return $class === LoginUser::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->loadUserByUsername($identifier);
    }
}
