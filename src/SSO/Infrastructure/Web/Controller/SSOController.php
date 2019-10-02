<?php

namespace SSO\Infrastructure\Web\Controller;

use Jumbojett\OpenIDConnectClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SSOController extends AbstractController
{
    /**
     * @Route("/sso")
     */
    public function ssoLogin() {
        $oidc = new OpenIDConnectClient(
            'https://sso.charite.de/adfs',
            //                                        'https://sso.charite.de/adfs/discovery/keys'
            'b75841f5-0da8-40b3-ae71-5e4f6d1f2d81',
            'Lsz9YToyXw7TGv7T2P0yiNXLThFrcUNW7PkX4wHq'
        );
        $oidc->providerConfigParam(
            [
                'token_endpoint'         => 'https://sso.charite.de/adfs/oauth2/token/',
                'userinfo_endpoint'      => 'https://sso.charite.de/adfs/userinfo',
                'end_session_endpoint'   => 'https://sso.charite.de/adfs/oauth2/logout',
                'authorization_endpoint' => 'https://sso.charite.de/adfs/oauth2/authorize/',
            ]
        );
        $oidc->setRedirectURL("https://levelup.charite.de/ssoSuccess/");
        $oidc->authenticate();
        $email = $oidc->getVerifiedClaims("upn");
        $username = $oidc->getVerifiedClaims("unique_name");
        $iat = gmdate("Y-m-d\TH:i:s\Z", ($oidc->getVerifiedClaims("iat")));
        $exp = gmdate("Y-m-d\TH:i:s\Z", $oidc->getVerifiedClaims("exp"));
        $auth_time = gmdate("Y-m-d\TH:i:s\Z", $oidc->getVerifiedClaims("auth_time"));

        return $this->render("sso.html.twig", ["results" =>
                                                   [
                                                       "email"        => $email,
                                                       "username"     => $username,
                                                       "iat"          => $iat,
                                                       "exp"          => $exp,
                                                       "auth_time"    => $auth_time,
                                                       "access_token" => print_r($oidc->getAccessToken(), 1),
                                                       "id_header"    => print_r($oidc->getIdTokenHeader(), 1),
                                                       "id_payload"   => print_r($oidc->getIdTokenPayload(), 1),
                                                       "refreshToken" => print_r($oidc->getRefreshToken(), 1),
                                                   ],
                                            ]
        );
    }

}
