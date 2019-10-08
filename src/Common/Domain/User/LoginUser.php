<?php

namespace Common\Domain\User;

use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginUser implements DDDValueObject, UserInterface
{
    use DefaultValueObjectComparison;

    /** @var Vorname */
    protected $vorname;

    /** @var Nachname */
    protected $nachname;

    /** @var Email */
    protected $email;

    /** @var Username */
    protected $usernameVO;

    /** @var bool */
    protected $istAdmin = FALSE;

    public static function fromValues(
        Vorname $vorname,
        Nachname $nachname,
        Email $email,
        Username $username
    ): self {
        $object = new self();

        $object->vorname = $vorname;
        $object->nachname = $nachname;
        $object->email = $email;
        $object->usernameVO = $username;

        return $object;
    }

    public function macheZuAdmin(): self {
        $newUser = self::fromValues($this->vorname, $this->nachname, $this->email, $this->usernameVO);
        $newUser->istAdmin = TRUE;

        return $newUser;
    }

    /**
     * Returns the roles granted to the user.
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles() {
        return $this->istAdmin
            ? ["ROLE_USER", "ROLE_ADMIN"]
            : ["ROLE_USER"];
    }

    /**
     * Returns the password used to authenticate the user.
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword() {
        return NULL;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt() {
        return NULL;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() {
        return $this->usernameVO->getValue();
    }

    /**
     * Removes sensitive data from the user.
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {
    }

    public function getVorname(): Vorname {
        return $this->vorname;
    }

    public function getNachname(): Nachname {
        return $this->nachname;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function getUsernameVO(): Username {
        return $this->usernameVO;
    }

    public function istAdmin(): bool {
        return $this->istAdmin;
    }

}