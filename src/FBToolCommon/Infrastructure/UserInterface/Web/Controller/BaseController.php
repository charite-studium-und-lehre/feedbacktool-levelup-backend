<?php

namespace FBToolCommon\Infrastructure\UserInterface\Web\Controller;

use Common\Domain\User\LoginUser;
use Studi\Domain\LoginHash;
use Studi\Domain\Service\LoginHashCreator;
use Studi\Domain\Studi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    public function getCurrentUserLoginHash(LoginHashCreator $loginHashCreator): ?LoginHash {
        $user = $this->getUser();
        if ($user && $user instanceof Studi) {
            return $user->getLoginHash();
        } elseif ($user && $user instanceof LoginUser) {
            return $loginHashCreator->createLoginHash($user->getUsernameVO());
        }
        return NULL;
    }
}
