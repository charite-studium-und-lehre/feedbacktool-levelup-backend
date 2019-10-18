<?php

declare(strict_types=1);

namespace SSO\Infrastructure\Web\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

final class ChariteGuardAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private const LOGIN_ROUTE = 'notLoggedIn';

    private $router;

    public function __construct(
        RouterInterface $router
    ) {
        $this->router = $router;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate(self::LOGIN_ROUTE);
    }

    public function supports(Request $request)
    {
        return FALSE;
//        return self::LOGIN_ROUTE === $request->attributes->get('_route');
    }

    public function getCredentials(Request $request)
    {
        return [];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return TRUE;
    }

    /**
     * Called when authentication executed and was successful!
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param string $providerKey The provider (i.e. firewall) key
     * @return Response|null
     */public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
            return new RedirectResponse($this->router->generate("login"));
}
}
