<?php

namespace FBToolCommon\Infrastructure\UserInterface\Web\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Studi\Domain\LoginHash;
use Studi\Domain\Service\LoginHashCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class BaseController extends AbstractController
{
    public function getCurrentUserLoginHash(LoginHashCreator $loginHashCreator): ?LoginHash {
        $user = $this->getUser();
        if ($user) {
            if ($user->getLoginHash()) {
                return $user->getLoginHash();
            } else {
                return $loginHashCreator->createLoginHash($user->getUsernameVO());
            }
        }

        return NULL;
    }

    protected function getJsonContentParams(Request $request) {
        $content = $request->getContent();

        if (empty($content)) {
            throw new BadRequestHttpException("Content is empty");
        }

        try {
            return new ArrayCollection(json_decode($content, TRUE));
        } catch (Exception $e) {
            throw new BadRequestHttpException("Content is not a valid json");
        }
    }
}
