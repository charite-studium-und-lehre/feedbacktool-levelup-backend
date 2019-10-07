<?php

namespace SSO\Infrastructure\Web\Controller;

use Common\Infrastructure\UserInterface\Web\Service\ChariteSSOService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class SSOController extends AbstractController
{
    /**
     * @Route("/api/login")
     * @Route("/ssoSuccess")
     */
    public function ssoLogin(Session $session, ChariteSSOService $chariteSSOService) {
        $username = $session->get("eingeloggterUser");

        if (!$username) {
            $username = $chariteSSOService->ssoGetUsername();
            if (!$username) {
                return new Response($chariteSSOService->getErrorMessage(), 404);
            }

            $session->set("eingeloggterUser", $username);
        }

        return new Response("Eingeloggt als " . $session->get("eingeloggterUser"), 200);
    }

}
