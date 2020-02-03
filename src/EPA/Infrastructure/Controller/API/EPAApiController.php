<?php

namespace EPA\Infrastructure\Controller\API;

use Common\Application\Command\CommandBus;
use EPA\Application\Command\FremdBewertungAbgebenCommand;
use EPA\Application\Command\FremdBewertungAnfragenCommand;
use EPA\Application\Command\SelbstBewertungAendernCommand;
use EPA\Domain\EPAKonstanten;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageToken;
use EPA\Domain\FremdBewertung\FremdBewertungsRepository;
use EPA\Domain\SelbstBewertungsTyp;
use EPA\Domain\Service\EpasFuerStudiService;
use EPA\Domain\Service\EpasService;
use Error;
use Exception;
use LevelUpCommon\Infrastructure\UserInterface\Web\Controller\BaseController;
use Studi\Domain\Service\LoginHashCreator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EPAApiController extends BaseController
{
    private LoginHashCreator $loginHashCreator;

    public function __construct(LoginHashCreator $loginHashCreator) {
        $this->loginHashCreator = $loginHashCreator;
    }

    /**
     * @Route("/api/epas", name="alleEpas", methods={"GET"})
     */
    public function alleEpas(EpasService $epasService): Response {
        session_write_close();
        $data = $epasService->getAlleEPAs();

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/epas/bewertungen", name="bewertungen", methods={"GET"})
     */
    public function bewertungen(EpasFuerStudiService $epasFuerStudiService): Response {
        $this->checkLogin();
        session_write_close();
        $loginHash = $this->getCurrentUserLoginHash($this->loginHashCreator);
        $data = $epasFuerStudiService->getEpaStudiData($loginHash);

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/epas/bewertungen", name="api_selbstbewertung_setzen", methods={"POST", "OPTIONS"})
     */
    public function aendereSelbstBewertung(Request $request, CommandBus $commandBus): Response {
        if ($request->getMethod() == "OPTIONS") {
            return new Response("", 200);
        }
        $this->checkLogin();
        $params = $this->getJsonContentParams($request);
        $epaID = $params->get("bewertungen")[0]["epaId"] ?? 0;
        $zutrauen = $params->get("bewertungen")[0]["zutrauen"] ?? 0;
        $gemacht = $params->get("bewertungen")[0]["gemacht"] ?? 0;

        $command = new SelbstBewertungAendernCommand();

        $command->loginHash = $this->getCurrentUserLoginHash($this->loginHashCreator)->getValue();
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
     * @Route("/api/epas/bewertungen/{tokenString}", name="fremdBewertungenPost", methods={"POST", "OPTIONS"})
     */
    public function fremdBewertungenPost(
        Request $request,
        EpasFuerStudiService $epasFuerStudiService,
        string $tokenString,
        FremdBewertungsRepository $fremdBewertungsRepository,
        FremdBewertungsAnfrageRepository $anfrageRepository,
        CommandBus $commandBus
    ): Response {
        if ($request->getMethod() == "OPTIONS") {
            return new Response("", 200);
        }
        $token = FremdBewertungsAnfrageToken::fromString($tokenString);
        $fremdBewertungsAnfrage = $anfrageRepository->byToken($token);
        if (!$fremdBewertungsAnfrage) {
            return new Response("Token nicht gefunden!", 404);
        }
        $params = $this->getJsonContentParams($request);
        $command = new FremdBewertungAbgebenCommand();
        $command->fremdBewertungsId = $fremdBewertungsRepository->nextIdentity()->getValue();
        $command->fremdBewertungsAnfrageId = $fremdBewertungsAnfrage->getId()->getValue();
        $command->loginHash = $fremdBewertungsAnfrage->getLoginHash();
        $command->fremdBewertungen = $params->get("bewertungen");
        $command->studiEmail = $fremdBewertungsAnfrage->getAnfrageDaten()->getStudiEmail()->getValue();
        $command->studiName = $fremdBewertungsAnfrage->getAnfrageDaten()->getStudiName()->getValue();
        $command->bewerterName = $fremdBewertungsAnfrage->getAnfrageDaten()->getFremdBerwerterName()->getValue();
        $command->bewerterEmail = $fremdBewertungsAnfrage->getAnfrageDaten()->getFremdBerwerterEmail()->getValue();

        try {
            $commandBus->execute($command);
        } catch (Exception $e) {
            return new Response($e->getMessage() . $e->getTraceAsString(), 400);
        }

        return new Response("Erfolg", 200);
    }

    /**
     * @Route("/api/epas/fremdbewertungen", name="fremdbewertungen", methods={"GET"})
     */
    public function fremdbewertungenAction(EpasFuerStudiService $epasFuerStudiService): Response {
        $this->checkLogin();
        session_write_close();
        $loginHash = $this->getCurrentUserLoginHash($this->loginHashCreator);
        $data = $epasFuerStudiService->getFremdBewertungen($loginHash);

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/epas/fremdbewertungen/anfragen", name="fremdbewertungsAnfragen", methods={"GET"})
     */
    public function fremdbewertungsAnfragenAction(EpasFuerStudiService $epasFuerStudiService): Response {
        $this->checkLogin();
        session_write_close();
        $loginHash = $this->getCurrentUserLoginHash($this->loginHashCreator);
        $data = $epasFuerStudiService->getFremdBewertungsAnfragen($loginHash);

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/epas/fremdbewertungen/anfragen", name="api_fremdbewertung_anfordern",
     *     methods={"POST","OPTIONS"})
     */
    public function frageFremdBewertungAnAction(
        Request $request,
        CommandBus $commandBus,
        FremdBewertungsAnfrageRepository $anfrageRepository,
        EpasFuerStudiService $epasFuerStudiService
    ): Response {
        if ($request->getMethod() == "OPTIONS") {
            return new Response("", 200);
        }
        $this->checkLogin();
        $params = $this->getJsonContentParams($request);

        $command = new FremdBewertungAnfragenCommand();
        $command->fremdBewertungsAnfrageId = $anfrageRepository->nextIdentity()->getValue();
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
        } catch (Exception $e) {
            return new Response($e->getMessage() . $e->getTraceAsString(), 400);
        } catch (Error $e) {
            return new Response($e->getMessage() . $e->getTraceAsString(), 400);
        }
        $anfrage = $anfrageRepository->byId(
            FremdBewertungsAnfrageId::fromInt($command->fremdBewertungsAnfrageId)
        );

        return new JsonResponse(
            $epasFuerStudiService->getFremdBewertungAnfrageDaten($anfrage),
            201
        );
    }

    /**
     * @Route("/api/epas/fremdbewertungen/anfragen/{tokenString}", name="api_fremdbewertung_abgabe_anfragen",
     *     methods={"GET"})
     */
    public function fremdbewertungAbgebenAnfrage(
        string $tokenString,
        FremdBewertungsAnfrageRepository $anfrageRepository
    ): Response {
        $token = FremdBewertungsAnfrageToken::fromString($tokenString);
        $fremdBewertungsAnfrage = $anfrageRepository->byToken($token);
        if (!$fremdBewertungsAnfrage) {
            return new Response("Token nicht gefunden!", 404);
        }
        $anfrageDaten = $fremdBewertungsAnfrage->getAnfrageDaten();

        return new JsonResponse(
            [
                "id"                     => $fremdBewertungsAnfrage->getId()->getValue(),
                "token"                  => $token->getValue(),
                "name"                   => $anfrageDaten->getFremdBerwerterName()->getValue(),
                "email"                  => $anfrageDaten->getFremdBerwerterEmail()->getValue(),
                "datum"                  => $anfrageDaten->getDatum()->toIsoString(),
                "studiName"              => $anfrageDaten->getStudiName()->getValue(),
                "studiEmail"             => $anfrageDaten->getStudiEmail()->getValue(),
                "angefragteTaetigkeiten" => $anfrageDaten->getAnfrageTaetigkeiten() . "",
                "kommentar"              => $anfrageDaten->getAnfrageKommentar() . "",
                "epas"                   => array_keys(EPAKonstanten::EPAS),
            ]
        );

    }

}
