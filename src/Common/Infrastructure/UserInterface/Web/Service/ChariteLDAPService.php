<?php

namespace Common\Infrastructure\UserInterface\Web\Service;

use Common\Domain\User\Email;
use Common\Domain\User\LoginUser;
use Common\Domain\User\Nachname;
use Common\Domain\User\Username;
use Common\Domain\User\Vorname;

class ChariteLDAPService
{
    const AUTH_FAILED = "authFailed";
    const SUCCESS = "success";

    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /** @var bool */
    private $tls;

    /** @var string */
    private $baseDn;

    /** @var string */
    private $bindDn;

    /** @var resource */
    private $connection;

    public function __construct(string $host, int $port, bool $tls, string $baseDn, string $bindDn) {
        $this->host = $host;
        $this->port = $port;
        $this->tls = $tls;
        $this->baseDn = $baseDn;
        $this->bindDn = $bindDn;
    }

    /**
     * Try to connect to configured LDAP server.
     * If username is given, an authorized bind is executed, otherwise an anonymous bind
     * returns "false" if LDAPs server is unreachable, otherwise AUTH_FAILED or SUCCESS
     */
    public function connect(?string $username = NULL, ?string $password = NULL): void {

        // unconnect if connected
        if ($this->connection) {
            $this->unconnect();
        }

        // put user to bind dn if username is given
        if ($username) {
            $bind_dn = str_replace("%", $username, $this->bindDn);
        }

        $protocol = $this->port == 389 ? "ldap://" : "ldaps://";
        $this->connection = ldap_connect($protocol . $this->host, $this->port);
        if (!$this->connection) {
            throw new \Exception("Cannot connect to LDAP - NO CONNECTION!");
        }

        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);

        if ($username) {
            // authenticated bind -> use "@" to suppress warning on wrong credentials
            $bind = @ldap_bind($this->connection, $bind_dn, $password);
        } else {
            // anonymous bind
            $bind = ldap_bind($this->connection);
        }

        if (!$bind) {
            $this->connection = NULL;
            throw new \Exception("Cannot connect to LDAP - BIND FAILED!");
        }
    }

    /**
     * Unconnect from LDAP server, if connected.
     */
    public function unconnect(): void {
        if ($this->connection) {
            ldap_unbind($this->connection);
        }
        $this->connection = NULL;
    }

    public function checkConnection(): bool {
        if (!$this->connection) {
            $this->connect();
        }

        return $this->connection ? TRUE : FALSE;
    }

    /**
     * Given an email, get the username of the LDAP user
     *
     * @param string $email
     * @return string|null|false string on success, false on "not found", null on connection error
     */
    public function getUsernameByEmail($email): ?string {
        $info = $this->getLdapInfoByEmail($email);
        if (!$info) {
            return $info;
        }
        if (isset($info["uid"][0])) {
            return $info["uid"][0];
        }

        return NULL;
    }

    /**
     * Given an email, return if the email exists in LDAP
     */
    public function emailExists(string $email): bool {
        return $this->getLdapInfoByEmail($email) ? TRUE : FALSE;
    }

    /**
     * Given an LDAP username, get the email of the LDAP user
     */
    public function getEmailByUsername(string $username): ?string {
        $info = $this->getUserInfoByUsername($username);
        if (empty($info["mail"][0])) {
            return NULL;
        }

        return $info["mail"][0];
    }

    /**
     * Given a username, get the whole user info array from the LDAP user
     */
    public function getUserInfoByUsername(string $username): ?array {
        $this->checkConnection();
        $filter = "(uid=$username)";

        return $this->getLdapInfoByFilter($filter);
    }

    /**
     * Given a username, get the whole user info array from the LDAP user
     */
    public function getLoginUserByUsername(string $username): ?LoginUser {
        $userInfo = $this->getUserInfoByUsername($username);
        if (!$userInfo) {
            return NULL;
        }

        $nachname = $userInfo["sn"][0];
        if (isset($userInfo["namenszusatz"][0])) {
            $nachname = $userInfo["namenszusatz"][0] . " " . $nachname;
        }

        return LoginUser::fromValues(
            Vorname::fromString($userInfo["givenname"][0]),
            Nachname::fromString($nachname),
            Email::fromString($userInfo["mail"][0]),
            Username::fromString($username),
            );
    }

    public function tryLdapCredentials(string $username, string $password) {
        try {
            $this->connect($username, $password);
        } catch (\Exception $e) {
            return TRUE;
        }
        $this->unconnect();

        return FALSE;
    }

    public function isLdapAktivStudent(string $email): bool {
        return $this->getLdapAktivStudentByEmail($email) ? TRUE : FALSE;
    }

    private function getLdapAktivStudentByEmail($email, $aktiv = TRUE): ?array {
        $aktivString = $aktiv ? "Y" : "N";
        $this->checkConnection();
        $filter = "(&(aktivstudent=$aktivString)(mail=$email))";

        return $this->getLdapInfoByFilter($filter);
    }

    private function getLdapInfoByEmail(string $email) {
        $this->checkConnection();
        $filter = "(mail=$email)";

        return $this->getLdapInfoByFilter($filter);
    }

    /**
     * Suche und filtere LDAP-Einträge.
     * Für manche Benutzer ist ein LDAP-Eintrag erreichbarm, auch wenn sie nicht existent sind.
     * Existente Nutzer haben
     * * eine uid
     * * KEINEN Eintrag stopinformation
     */
    private function getLdapInfoByFilter(string $filter): ?array {
        $read = ldap_search($this->connection, $this->baseDn, $filter);
        if (!$read) {
            return NULL;
        }
        $info = ldap_get_entries($this->connection, $read);
        foreach ($info as $infoEntry) {
            //if (isset($infoEntry["uid"][0]) && !isset($infoEntry["stopinformation"])) {
            if (isset($infoEntry["uid"][0]) && isset($infoEntry["mail"][0])) {
                return $infoEntry;
            }
        }
        foreach ($info as $infoEntry) {
            if (isset($infoEntry["uid"][0])) {
                return $infoEntry;
            }
        }

        return NULL;
    }

}