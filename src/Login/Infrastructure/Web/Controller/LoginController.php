<?php

namespace Login\Infrastructure\Web\Controller;

use Common\Domain\User\LoginUser;
use Common\Infrastructure\UserInterface\Web\Service\ChariteLDAPService;
use Common\Infrastructure\UserInterface\Web\Service\ChariteLDAPUserProvider;
use Common\Infrastructure\UserInterface\Web\Service\ChariteSSOService;
use LevelUpCommon\Infrastructure\UserInterface\Web\Controller\BaseController;
use Login\Infrastructure\Web\Service\FrontendUrlService;
use Login\Infrastructure\Web\Service\UserSwitcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Studi\Domain\Matrikelnummer;
use Studi\Domain\Service\LoginHashCreator;
use Studi\Domain\Service\StudiHashCreator;
use Studi\Domain\Studi;
use Studi\Domain\StudiData;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class LoginController extends BaseController
{
    private FrontendUrlService $frontendUrlService;

    public function __construct(FrontendUrlService $frontendUrlService) {
        $this->frontendUrlService = $frontendUrlService;
    }

    /**
     * @Route("/login", name="login")
     * @Route("/ssoSuccess")
     */
    public function ssoLogin(
        Request $request,
        LoginHashCreator $loginHashCreator,
        ChariteSSOService $chariteSSOService,
        StudiRepository $studiRepository,
        ChariteLDAPUserProvider $chariteLDAPUserProvider,
        TokenStorageInterface $tokenStorage,
        UserSwitcher $userSwitcher
    ): Response {
        $userSwitcher->unsetUserSwitched();
        if ($request->get("code") && !$chariteSSOService->hasPendingSSOAuth()) {
            return new Response("Fehler: Kann code ohne gestartetem SSO-Request nicht verarbeiten", 400);
        }
        if (!$tokenStorage->getToken()?->getUser() instanceof LoginUser) {
            $username = $chariteSSOService->ssoTryAuthPhase2AndGetUsername();
            if (!$username) {
                $chariteSSOService->deletePendingSSOAuth();

                return new Response($chariteSSOService->getErrorMessage(), 400);
            }
            $loginUser = $chariteLDAPUserProvider->loadUserByUsername($username);
            if (!$loginUser) {
                return new Response("Benutzer '$username' im LDAP nicht gefunden!", 400);
            }

            $loginHash = $loginHashCreator->createLoginHash($username);
            $studiByLoginHash = $studiRepository->byLoginHash($loginHash);

            if ($studiByLoginHash) {
                $this->loginUser($tokenStorage, $studiByLoginHash->macheZuLoginUser($loginUser));
            } else {
                $this->loginUser($tokenStorage, $loginUser);
            }
        }

        return $this->redirect($this->frontendUrlService->getFrontendUrl());
    }

    /** @Route("/api/stammdaten", name="isLoggedIn", methods="GET") */
    public function checkStammdatenAction(): Response {
        /** @var LoginUser $loginUser */
        $loginUser = $this->getUser();
        if ($this->getUser()) {
            return new JsonResponse(
                [
                    "vorname"             => $loginUser->getVorname()->getValue(),
                    "nachname"            => $loginUser->getNachname()->getValue(),
                    "email"               => $loginUser->getEmail()->getValue(),
                    "stammdatenVorhanden" => $loginUser instanceof Studi,
                    "istAdmin"            => $loginUser->istAdmin(),
                ], 200
            );
        }

        return new Response(NULL, 401);
    }

    /** @Route("/api/stammdaten", name="stammdaten", methods={"POST", "OPTIONS"}) */
    public function setStammdatenAction(
        Request $request,
        StudiRepository $studiRepository,
        LoginHashCreator $loginHashCreator,
        StudiHashCreator $studiHashCreator
    ): Response {
        if ($request->getMethod() == "OPTIONS") {
            return new Response("", 200);
        }
        $params = $this->getJsonContentParams($request);

        /** @var int $matrikelnummer */
        $matrikelnummer = $params->get("matrikelnummer");
        if (!$matrikelnummer) {
            return new Response("'matrikelnummer' muss als POST-Param gg. werden! -> Content:" . $request->getContent(),
                                400);
        }

        /** @var LoginUser $loginUser */
        $loginUser = $this->getUser();
        $studiData = StudiData::fromValues(
            Matrikelnummer::fromInt($matrikelnummer),
            $loginUser->getVorname(),
            $loginUser->getNachname()
        );
        $studiHash = $studiHashCreator->createStudiHash($studiData);
        $studi = $studiRepository->byStudiHash($studiHash);
        if (!$studi) {
            return new Response("Es wurde kein Studi gefunden, auf den Name/Matrikel-Hash passt. Aktuell können sich nur immatrikulierte Studierende des MSM2 einloggen!",
                                404);
        }
        $loginHash = $loginHashCreator->createLoginHash($loginUser->getUsernameVO());
        $studi->setLoginHash($loginHash);
        $studiRepository->flush();

        //        $this->loginUser($tokenStorage, $studi);

        return new Response("OK", 200);
    }

    /** @Route("/notLoggedIn", name="notLoggedIn") */
    public function notLoggedIn(): Response {
        return new Response();
    }

    /** @Route("/logoutFromSSO", name="logoutFromSSO") */
    public function ssoLogoutAction(ChariteSSOService $chariteSSOService, UserSwitcher $userSwitcher): Response {
        $userSwitcher->unsetUserSwitched();

        // Service macht eine Weiterleitung
        $chariteSSOService->signOut();

        return new Response("...");
    }

    /** @Route("/redirectToLogout", name="redirectToLogout") */
    /** @Route("/logout", name="logout") */
    public function redirectToLogout(): Response {
        return $this->redirectToRoute("logoutFromSSO");
    }

    /** @Route("/switchToFrontend", name="switchToFrontend") */
    public function switchToFrontend(): Response {
        return $this->redirect($this->frontendUrlService->getFrontendUrl());
    }

    /** @Route("/api/userInfo", name="userInfo")
     * @IsGranted("ROLE_ADMIN")
     */
    public function userInfo(
        TokenStorageInterface $tokenStorage,
        Request $request,
        ChariteLDAPService $chariteLDAPService
    ): Response {
        $user = $this->getUser();
        dump($this->getUser());
        dump($this->getUser()->getRoles());
        dump($tokenStorage);
        dump($_SESSION);
        dump($request->headers->get("referer"));
        if ($user instanceof Studi) {
            dump($user->getStudiHash());
        }
        if ($request->get("mailInfo") && $this->getUser()->istAdmin()) {
            $username = $chariteLDAPService->getUsernameByEmail($request->get("mailInfo"));
            dump($chariteLDAPService->getUserInfoByUsername($username));
            dump($chariteLDAPService->getLoginUserByUsername($username));
        }

        return new Response(
            "<h1><a href='"
            . $this->frontendUrlService->getFrontendUrl()
            . "'>Gehe zu Dashboard</a><br/></h1>"
            . "<h1><a href=''>Neu laden</a><br/></h1><a href='"
            . $this->generateUrl("switchUser") . "'>Zurück zu SwitchUser</a></h1>"
        );
    }

    /**
     * @Route("/admin/switchUser", name="switchUser")
     * @IsGranted("ROLE_ADMIN")
     */
    public function switchUserAction(
        Request $request,
        StudiRepository $studiRepository,
        LoginHashCreator $loginHashCreator,
        TokenStorageInterface $tokenStorage,
        UserSwitcher $userSwitcher
    ): Response {
        /** @var LoginUser $currentUser */
        $currentUser = $this->getUser();
        $studiHash = $request->get("studiHash");
        if ($studiHash) {
            $studi = $studiRepository->byStudiHash(StudiHash::fromString($studiHash));
            if (!$studi) {
                return new Response("Studi nicht gefunden!");
            }

            $switchedUser = $studi->macheZuLoginUser($this->getUser());
            $this->loginUser($tokenStorage, $switchedUser);
            $userSwitcher->setUserSwitched($currentUser->getUsernameVO());

            return $this->redirectToRoute("userInfo");

        }
        $allStudis = $studiRepository->all();

        return $this->render(
            "switchUser.html.twig",
            ["studis" => $allStudis]
        );
    }

    private function loginUser(TokenStorageInterface $tokenStorage, LoginUser $loginUser): void {
        $token = new UsernamePasswordToken($loginUser, "main", $loginUser->getRoles());
        $tokenStorage->setToken($token);
    }
}
