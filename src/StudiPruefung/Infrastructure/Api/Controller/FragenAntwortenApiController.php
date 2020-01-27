<?php

namespace StudiPruefung\Infrastructure\Api\Controller;

use Studi\Domain\Studi;
use StudiPruefung\Domain\Service\StudiPruefungFragenAntwortenService;
use StudiPruefung\Domain\StudiPruefungsId;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FragenAntwortenApiController extends AbstractController
{

    private StudiPruefungsRepository $studiPruefungsRepository;

    private StudiPruefungFragenAntwortenService $studiPruefungFragenAntwortenService;

    public function __construct(
        StudiPruefungsRepository $studiPruefungsRepository,
        StudiPruefungFragenAntwortenService $studiPruefungFragenAntwortenService
    ) {
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->studiPruefungFragenAntwortenService = $studiPruefungFragenAntwortenService;
    }

    /**
     * @Route("/api/pruefungen/{studiPruefungsIdInt}/fragen")
     */
    public function jsonStudiPruefungsDetailsAction(int $studiPruefungsIdInt) {
        $eingeloggterStudi = $this->getUser();
        if (!$eingeloggterStudi instanceof Studi) {
            return new JsonResponse(["pruefungen" => []], 200);
        }
        $studiPruefungsId = StudiPruefungsId::fromInt($studiPruefungsIdInt);
        $studiPruefung = $this->studiPruefungsRepository->byId($studiPruefungsId);
        //        if (!$studiPruefung->getStudiHash()->equals($eingeloggterStudi->getStudiHash())) {
        //            return new JsonResponse("Studiprüfungs-ID entspricht nicht eingeloggtem Studi.", 400);
        //        }

        $fragenUndAntworten = $this->studiPruefungFragenAntwortenService
            ->getErgebnisAlsJsonArray($studiPruefung);

        return new JsonResponse($fragenUndAntworten, 200);

    }

}
