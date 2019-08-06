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
                                        '2a4a78f8-4586-45ec-b507-8e0abedd854d',
//                                        'pah9naiV%i1quaeK0auN"aoQu8phah'
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
        $oidc->setRedirectURL("https://feedbacktool.charite.de/ssoSuccess/index.html");
        $oidc->authenticate();
        $name = $oidc->requestUserInfo('given_name');

        return $this->render("sso.html.twig", ["results" => [$name]]);
    }

}