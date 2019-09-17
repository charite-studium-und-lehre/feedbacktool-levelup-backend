<?php

namespace StudiPruefung\Infrastructure\Api\Controller;

use Pruefung\Domain\PruefungsRepository;
use SSO\Domain\EingeloggterStudiService;
use StudiMeilenstein\Domain\Meilenstein;
use StudiMeilenstein\Domain\Service\MeilensteinExportService;
use StudiPruefung\Domain\StudiPruefungsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StudiMeilensteinApiController extends AbstractController
{

    /** @var EingeloggterStudiService */
    private $eingeloggterStudiService;

    /** @var StudiPruefungsRepository */
    private $studiPruefungsRepository;

    /** @var PruefungsRepository */
    private $pruefungsRepository;

    public function __construct(
        EingeloggterStudiService $eingeloggterStudiService,
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsRepository $pruefungsRepository
    ) {
        $this->eingeloggterStudiService = $eingeloggterStudiService;
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
    }

    /**
     * @Route("/api/meilensteine")
     */
    public function jsonStudiPruefungAction() {
        $eingeloggterStudi = $this->eingeloggterStudiService->getEingeloggterStudi();
        $studiPruefungen = $this->studiPruefungsRepository->allByStudiHash(
            $eingeloggterStudi->getStudiHash()
        );
        $returnArray = [];
        foreach ($studiPruefungen as $studiPruefung) {
            $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
            $code = $pruefung->getFormat()->getCode();
            $datum = $pruefung->getDatum();
            $name = $pruefung->getFormat()->getTitel();
        }

        return new JsonResponse(
            ["meilensteine" => $meilensteinArray]
        );

    }

}
