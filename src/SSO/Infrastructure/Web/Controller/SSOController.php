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
        $oidc->setCertPath('/etc/ssl/certs');
        $oidc->setRedirectURL("https://feedbacktool.charite.de/ssoSuccess/index.php");
        $oidc->authenticate();
        $name = $oidc->requestUserInfo('given_name');

        return $this->render("sso.html.twig", ["results" => [$name]]);
    }

}