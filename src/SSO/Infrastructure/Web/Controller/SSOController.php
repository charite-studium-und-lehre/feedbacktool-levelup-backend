<?php

namespace SSO\Infrastructure\Web\Controller;

use Common\Domain\User\LoginUser;
use Common\Infrastructure\UserInterface\Web\Service\ChariteLDAPUserProvider;
use Common\Infrastructure\UserInterface\Web\Service\ChariteSSOService;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SSOController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @Route("/ssoSuccess")
     */
    public function ssoLogin(
        Request $request,
        ChariteSSOService $chariteSSOService,
        ChariteLDAPUserProvider $chariteLDAPUserProvider,
        TokenStorageInterface $tokenStorage
    ) {
        if ($request->get("code") && !$chariteSSOService->hasPendingSSOAuth()) {
            return new Response("Fehler: Kann code ohne gestartetem SSO-Request nicht verarbeiten", 400);
        }
        if (!$tokenStorage->getToken()->getUser() instanceof LoginUser) {
            $username = $chariteSSOService->ssoTryAuthPhase2AndGetUsername();
            if (!$username) {
                $chariteSSOService->deletePendingSSOAuth();
                return new Response($chariteSSOService->getErrorMessage(), 400);
            }
            $loginUser = $chariteLDAPUserProvider->loadUserByUsername($username);
            if (!$loginUser) {
                return new Response("Benutzer '$username' im LDAP nicht gefunden!", 400);
            }

            $this->loginUser($tokenStorage, $loginUser);
        }

        return new Response("Eingeloggt als " . $tokenStorage->getToken()->getUser()->getUsername(), 200);
    }

    /** @Route("/logout", name="logout") */
    public function logoutAction(Session $session) {
        $session->set("eingeloggterUser", NULL);

        return new Response("OK", 200);
    }

    /** @Route("/api/ssoLogout", name="apiLogout") */
    public function ssoLogoutAction(ChariteSSOService $chariteSSOService) {
        $chariteSSOService->signOut(NULL);
    }

    /** @Route("/redirectToSSO", name="redirectToSSO") */
    public function redirectToSSO() {
        return $this->redirectToRoute("login");
    }

    /** @Route("/switchToFrontend", name="switchToFrontend") */
    public function switchToFrontend() {
        return $this->redirect("/app");
    }

    /** @Route("/api/userInfo", name="userInfo") */
    public function userInfo(TokenStorageInterface $tokenStorage) {
        $user = $this->getUser();
        dump($this->getUser());
        dump($this->getUser()->getRoles());
        dump($tokenStorage);
        if ($user instanceof Studi) {
            dump($user->getStudiHash());
        }

        return new Response(
            ""
        );
    }

    /**
     * @Route("/admin/switchUser", name="switchUser")
     * @IsGranted("ROLE_ADMIN")
     */
    public function switchUser(
        Request $request,
        StudiRepository $studiRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $studiHash = $request->get("studiHash");
        if ($studiHash) {
            $studi = $studiRepository->byHash(StudiHash::fromString($studiHash));
            if (!$studi) {
                return new Response("Studi nicht gefunden!");
            }

            $switchedUser = $studi->macheZuLoginUser($this->getUser());
            $this->loginUser($tokenStorage, $switchedUser);
            return $this->redirectToRoute("userInfo");

        }
        $allStudis = $studiRepository->all();

        return $this->render(
            "switchUser.html.twig",
            ["studis" => $allStudis]
        );
    }

    private function loginUser(TokenStorageInterface $tokenStorage, LoginUser $loginUser): void {
        $token = new UsernamePasswordToken($loginUser, [], "main", $loginUser->getRoles());
        $tokenStorage->setToken($token);
    }

}
