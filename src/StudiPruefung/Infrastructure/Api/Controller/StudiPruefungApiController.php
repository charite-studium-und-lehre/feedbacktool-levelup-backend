<?php

namespace StudiPruefung\Infrastructure\Api\Controller;

use Pruefung\Domain\PruefungsRepository;
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

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    /** @var StudiPruefungErgebnisService */
    private $studiPruefungsErgebnisService;

    public function __construct(
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsRepository $pruefungsRepository,
        StudiPruefungErgebnisService $studiPruefungsErgebnisService
    ) {
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
        $this->studiPruefungsErgebnisService = $studiPruefungsErgebnisService;
    }

    /**
     * @Route("/api/pruefungen")
     */
    public function jsonStudiPruefungAction() {
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
    public function jsonStudiPruefungsDetailsAction(
        StudiPruefungErgebnisService $ergebnisService,
        int $studiPruefungsIdInt
    ) {
        $eingeloggterStudi = $this->getUser();
        if (!$eingeloggterStudi instanceof Studi) {
            return new JsonResponse(["pruefungen" => []], 200);
        }
        $studiPruefungsId = StudiPruefungsId::fromInt($studiPruefungsIdInt);
        $studiPruefung = $this->studiPruefungsRepository->byId($studiPruefungsId);
        if (!$studiPruefung->getStudiHash()->equals($eingeloggterStudi->getStudiHash())) {
            return new JsonResponse("Studiprüfungs-ID entspricht nicht eringeloggtem Studi.", 400);
        }

        $gesamtErgebnis = $ergebnisService->getErgebnisAlsJsonArray($studiPruefung);

        return new JsonResponse($gesamtErgebnis, 200);

    }

}
