<?php

namespace StudiPruefung\Infrastructure\Api\Controller;

use Studi\Domain\Studi;
use StudiPruefung\Domain\Service\StudiPruefungErgebnisService;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StudiPruefungApiController extends AbstractController
{

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    /** @var StudiPruefungErgebnisService */
    private $studiPruefungsErgebnisService;

    public function __construct(
        StudiPruefungsRepository $studiPruefungsRepository,
        StudiPruefungErgebnisService $studiPruefungsErgebnisService
    ) {
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->studiPruefungsErgebnisService = $studiPruefungsErgebnisService;
    }

    /**
     * @Route("/api/pruefungen")
     */
    public function jsonStudiPruefungAction() {
        session_write_close();
        $eingeloggterStudi = $this->getUser();
        if (!$eingeloggterStudi instanceof Studi) {
            return new JsonResponse(["pruefungen" => []], 404);
        }
        $studiPruefungen = $this->studiPruefungsRepository->allByStudiHash(
            $eingeloggterStudi->getStudiHash()
        );
        $returnArray = [];
        foreach ($studiPruefungen as $studiPruefung) {
            $returnArray[] = $this->studiPruefungsErgebnisService->getErgebnisAlsJsonArray($studiPruefung);
        }

        return new JsonResponse(["pruefungen" => $returnArray], 200);
    }

    /**
     * @Route("/api/pruefungen/{studiPruefungsIdInt}")
     */
    public function jsonStudiPruefungsDetailsAction(int $studiPruefungsIdInt) {
        session_write_close();
        $eingeloggterStudi = $this->getUser();
        if (!$eingeloggterStudi instanceof Studi) {
            return new JsonResponse(["pruefungen" => []], 200);
        }
        $studiPruefungsId = StudiPruefungsId::fromInt($studiPruefungsIdInt);
        $studiPruefung = $this->studiPruefungsRepository->byId($studiPruefungsId);
        if (!$studiPruefung->getStudiHash()->equals($eingeloggterStudi->getStudiHash())) {
            return new JsonResponse("Studiprüfungs-ID entspricht nicht eingeloggtem Studi.", 400);
        }

        $gesamtErgebnis = $this->studiPruefungsErgebnisService->getErgebnisAlsJsonArray($studiPruefung);

        return new JsonResponse($gesamtErgebnis, 200);
    }

}
