<?php

namespace EPA\Infrastructure\Controller\API;

use Common\Application\Command\CommandBus;
use EPA\Application\Command\SelbstBewertungErhoehenCommand;
use EPA\Application\Command\SelbstBewertungVermindernCommand;
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
     * @Route("/api/epa/meine", name="meine_epas")
     */
    public function meineEpas(EpasFuerStudiService $epasFuerStudiService) {
        $data = $epasFuerStudiService->getEpaStudiData(
            $this->getCurrentUserLoginHash($this->loginHashCreator)
        );

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/epa/selbstbewertung/erhoehen", name="api_selbstbewertung_erhoehen")
     * @Route("/api/epa/meine", name="api_selbstbewertung_erhoehen")
     */
    public function erhoeheSelbstbewertungAction(Request $request, CommandBus $commandBus, $vermindern = FALSE) {
        $epaId = $request->get("epaID");
        if ($request->get("typ") == "gemacht") {
            $typ = SelbstBewertungsTyp::GEMACHT;
        } elseif ($request->get("typ") == "zutrauen") {
            $typ = SelbstBewertungsTyp::ZUTRAUEN;
        } else {
            return new Response("Parameter 'typ' muss gegeben werden als 'gemacht' oder 'zutrauen'", 400);
        }

        if ($vermindern) {
            $command = new SelbstBewertungVermindernCommand();
        } else {
            $command = new SelbstBewertungErhoehenCommand();
        }

        $command->loginHash = $this->getCurrentUserLoginHash($this->loginHashCreator);
        $command->selbstBewertungsTyp = $typ;
        $command->epaId = $epaId;

        try {
            $commandBus->execute($command);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), 400);
        }

        return new Response("Erfolg", 200);
    }

    /**
     * @Route("/api/epa/selbstbewertung/vermindern", name="api_selbstbewertung_vermindern")
     */
    public function vermindereSelbstbewertungAction(Request $request, CommandBus $commandBus) {
        return $this->erhoeheSelbstbewertungAction($request, $commandBus, TRUE);
    }

}
