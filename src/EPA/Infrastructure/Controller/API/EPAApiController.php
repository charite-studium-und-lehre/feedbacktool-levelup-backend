<?php

namespace EPA\Infrastructure\Controller\API;

use Common\Application\Command\CommandBus;
use EPA\Application\Command\FremdBewertungAnfragenCommand;
use EPA\Application\Command\SelbstBewertungAendernCommand;
use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use EPA\Domain\SelbstBewertungsTyp;
use EPA\Domain\Service\EpasFuerStudiService;
use FBToolCommon\Infrastructure\UserInterface\Web\Controller\BaseController;
use Studi\Domain\Service\LoginHashCreator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EPAApiController extends BaseController
{
    /** @var LoginHashCreator */
    private $loginHashCreator;

    public function __construct(LoginHashCreator $loginHashCreator) {
        $this->loginHashCreator = $loginHashCreator;
    }

    /**
     * @Route("/api/epas", name="meine_epas", methods={"GET", "OPTIONS"})
     */
    public function meineEpas(EpasFuerStudiService $epasFuerStudiService) {
        session_write_close();
        if (!$this->getCurrentUserLoginHash($this->loginHashCreator)) {
            return new Response("Nicht eingeloggt?", 401);
        }
        $data = $epasFuerStudiService->getEpaStudiData(
            $this->getCurrentUserLoginHash($this->loginHashCreator)
        );

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/epas/{epaID}", name="api_selbstbewertung_setzen", methods={"POST", "OPTIONS"})
     */
    public function aendereSelbstBewertung(Request $request, CommandBus $commandBus, int $epaID) {
        if ($request->getMethod() == "OPTIONS") {
            return new Response("", 200);
        }
        $params = $this->getJsonContentParams($request);
        //        $params = $request;
        $zutrauen = $params->get("zutrauen") ?: 0;
        $gemacht = $params->get("gemacht") ?: 0;

        try {
            EPABewertung::fromValues($zutrauen, EPA::fromInt(111));
            EPABewertung::fromValues($gemacht, EPA::fromInt(111));
        } catch (\Exception $e) {
            new Response("Bewertung nicht zwischen 0 und 5!", 400);
        }

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

    /**
     * @Route("/api/epas/fremdbewertung/anfrage", name="api_fremdbewertung_anfordern", methods={"POST", "OPTIONS"})
     */
    public function frageFremdBewertungAnfragen(Request $request, CommandBus $commandBus) {
        if ($request->getMethod() == "OPTIONS") {
            return new Response("", 200);
        }
        $params = $this->getJsonContentParams($request);
//                $params = $request;

        $command = new FremdBewertungAnfragenCommand();
        $command->loginHash = $this->getCurrentUserLoginHash($this->loginHashCreator);
        $command->fremdBewerterName = $params->get("fremdBewerterName");
        $command->fremdBewerterEmail = $params->get("fremdBewerterEmail");
        $command->angefragteTaetigkeiten = $params->get("angefragteTaetigkeiten");
        $command->kommentar = $params->get("kommentar");

        $command->studiName = $this->getLoginUser()->getVollerNameString();
        $command->studiEmail = $this->getLoginUser()->getEmail()->getValue();

        if (!$command->loginHash) {
            return new Response("Nicht eingeloggt?", 401);
        }
        try {
            $commandBus->execute($command);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 400);
        }

        return new Response("Created", 201);
    }

}
