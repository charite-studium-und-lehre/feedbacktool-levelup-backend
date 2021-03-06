<?php

namespace LevelUpCommon\Infrastructure\UserInterface\Web\Controller;

use Common\Domain\User\LoginUser;
use Doctrine\Common\Collections\ArrayCollection;
use Error;
use Exception;
use Studi\Domain\LoginHash;
use Studi\Domain\Service\LoginHashCreator;
use Studi\Domain\Studi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseController extends AbstractController
{
    public function getCurrentUserLoginHash(LoginHashCreator $loginHashCreator): ?LoginHash {
        $user = $this->getUser();
        if ($user) {
            if ($user instanceof Studi && $user->getLoginHash()) {
                return $user->getLoginHash();
            } elseif ($user instanceof LoginUser) {
                return $loginHashCreator->createLoginHash($user->getUsernameVO());
            }
        }

        return NULL;
    }

    /** @return ArrayCollection<string, array> */
    protected function getJsonContentParams(Request $request): ArrayCollection {
        /** @var string $content */
        $content = $request->getContent();

        if (empty($content)) {
            throw new BadRequestHttpException("Content is empty");
        }

        try {
            return new ArrayCollection(json_decode($content, TRUE));
        } catch (Exception $e) {
            throw new BadRequestHttpException("Content is not a valid json");
        } catch (Error $e) {
            throw new BadRequestHttpException("Content is not a valid json");
        }
    }

    protected function getLoginUser(): ?LoginUser {
        return $this->getUser();
    }

    protected function checkLogin(): void {
        if (!$this->getUser()) {
            throw new HttpException(401, "Nicht eingeloggt");
        }
    }
}
