<?php

namespace EPA\Infrastructure\Controller\API;

use Common\Application\Command\CommandBus;
use EPA\Application\Command\SelbstBewertungErhoehenCommand;
use EPA\Application\Command\SelbstBewertungAendernCommand;
use EPA\Domain\SelbstBewertungsTyp;
use EPA\Domain\Service\EpasFuerStudiService;
use FBToolCommon\Infrastructure\UserInterface\Web\Controller\BaseController;
use Studi\Domain\Service\LoginHashCreator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EPAStatusApiController extends BaseController
{
    /** @var LoginHashCreator */
    private $loginHashCreator;

    public function __construct(LoginHashCreator $loginHashCreator) {
        $this->loginHashCreator = $loginHashCreator;
    }

    /**
     * @Route("/api/epas", name="meine_epas")
     */
    public function meineEpas(EpasFuerStudiService $epasFuerStudiService) {
        if (!$this->getCurrentUserLoginHash($this->loginHashCreator)) {
            return new Response("Nicht eingeloggt?", 401);
        }
        $data = $epasFuerStudiService->getEpaStudiData(
            $this->getCurrentUserLoginHash($this->loginHashCreator)
        );

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/epas/{epaID}", name="api_selbstbewertung_setzen")
     */
    public function aendereSelbstBewertung(Request $request, CommandBus $commandBus, int $epaID) {
        if ($request->getMethod() == "OPTIONS") {
            return new Response("", 200);
        }
        $params = $this->getJsonContentParams($request);
        $zutrauen = $params->get("zutrauen") ?: 0;
        $gemacht = $params->get("gemacht") ?: 0;

        $command = new SelbstBewertungAendernCommand();

        $command->loginHash = $this->getCurrentUserLoginHash($this->loginHashCreator);
        if (!$command->loginHash) {
            return new Response("Nicht eingeloggt?", 401);
        }
        $command->epaId = $epaID;
        $command->zutrauen = $zutrauen;
        $command->gemacht = $gemacht;

        $commandBus->execute($command);

        return new Response("Erfolg", 200);
    }

}
