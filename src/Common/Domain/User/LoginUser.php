<?php

namespace Common\Domain\User;

use Common\Domain\DDDValueObject;
use Common\Domain\DefaultValueObjectComparison;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginUser implements DDDValueObject, UserInterface
{
    use DefaultValueObjectComparison;

    protected Vorname $vorname;

    protected Nachname $nachname;

    protected Email $email;

    protected Username $usernameVO;

    protected bool $istAdmin = FALSE;

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
     * @return string[]
     */
    public function getRoles(): array {
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
    public function getPassword(): ?string {
        return NULL;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string {
        return NULL;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): string {
        return $this->usernameVO->getValue();
    }

    /**
     * Removes sensitive data from the user.
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void {
    }

    public function getVorname(): Vorname {
        return $this->vorname;
    }

    public function getNachname(): Nachname {
        return $this->nachname;
    }

    public function getVollerNameString(): string {
        return $this->vorname->getValue() . " " . $this->nachname->getValue();
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