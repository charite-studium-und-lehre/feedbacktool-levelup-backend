<?php

namespace Common\Infrastructure\UserInterface\Web\Service;

use Common\Domain\User\Username;
use Exception;
use Jumbojett\OpenIDConnectClient;
use UnexpectedValueException;

class ChariteSSOService
{
    private string $clientId;

    private string $clientSecret;

    private string $redirectURL;

    private string $providerUrl;

    private string $tokenEndpoint;

    private string $userinfoEndpoint;

    private string $endSessionEndpoint;

    private string $authorizationEndpoint;

    private string $errorMessage = "";

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $redirectURL,
        string $providerUrl,
        string $tokenEndpoint,
        string $userinfoEndpoint,
        string $endSessionEndpoint,
        string $authorizationEndpoint
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectURL = $redirectURL;
        $this->providerUrl = $providerUrl;
        $this->tokenEndpoint = $tokenEndpoint;
        $this->userinfoEndpoint = $userinfoEndpoint;
        $this->endSessionEndpoint = $endSessionEndpoint;
        $this->authorizationEndpoint = $authorizationEndpoint;
    }

    public function hasPendingSSOAuth(): bool {
        return (!empty($_SESSION["openid_connect_state"]));
    }

    public function deletePendingSSOAuth(): void {
        unset ($_SESSION["openid_connect_state"]);
        unset ($_SESSION["openid_connect_nonce"]);
    }

    /**
     * Returns Username of logged in user on success, NULL on error.
     * If user is not logged in, a redirect will be done directly in this service without Symfony
     */
    public function ssoTryAuthPhase2AndGetUsername(): ?Username {
        $oidc = $this->initializeOpenid();

        try {
            $oidc->authenticate();
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();

            return NULL;
        }

        $username = $oidc->getVerifiedClaims("unique_name");

        if (strpos($username, 'CHARITE\\') !== 0) {
            $this->errorMessage = "Kein Charité-Nutzer!";

            return NULL;
        }
        $username = substr($username, 8);

        return Username::fromString($username);
    }

    /** returns TRUE on success, FALSE on error */
    public function signOut(): bool {
        $oidc = $this->initializeOpenid();

        try {
            $oidc->signOut(NULL, NULL);
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();

            return FALSE;
        }

        return TRUE;
    }

    public function getErrorMessage(): string {
        return $this->errorMessage;
    }

    /**
     * @return OpenIDConnectClient
     */
    private function initializeOpenid(): OpenIDConnectClient {
        if (!$this->clientId || !$this->clientSecret || !$this->redirectURL) {
            throw new UnexpectedValueException(
                "Für Charite-OpenID-SSO müssen clientId, clientSecret und redirectURL konfiguriert sein!"
            );
        }

        $oidc = new OpenIDConnectClient(
            $this->providerUrl,
            $this->clientId,
            $this->clientSecret
        );
        $oidc->providerConfigParam(
            [
                'token_endpoint'         => $this->tokenEndpoint,
                'userinfo_endpoint'      => $this->userinfoEndpoint,
                'end_session_endpoint'   => $this->endSessionEndpoint,
                'authorization_endpoint' => $this->authorizationEndpoint,
            ]
        );
        $oidc->setRedirectURL($this->redirectURL);

        return $oidc;
    }

}