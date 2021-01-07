<?php

namespace Common\Infrastructure\UserInterface\Web\Service;

use Common\Domain\User\LoginUser;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ChariteLDAPUserProvider implements UserProviderInterface
{

    private ChariteLDAPService $chariteLDAPService;

    public function __construct(ChariteLDAPService $chariteLDAPService) {
        $this->chariteLDAPService = $chariteLDAPService;
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
        $loginUser = $this->chariteLDAPService->getLoginUserByUsername($username);
        if (!$loginUser) {
            return NULL;
        }
        if (in_array($loginUser->getUsername(),
                     [
                         "dittmarm",
                         "alhassam",
                         "petzolma",
                         "franzann",
                         "htame",
                         "linkea",
                         "domansmo",
                         "geppermi",
			 "aleksanv",
			 "beyers",
                     ]
        )) {
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
     * @throws UsernameNotFoundException if the user is not found
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
}
