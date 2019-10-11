<?php

namespace StudiPruefung\Infrastructure\Api\Controller;

use Pruefung\Domain\PruefungsRepository;
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

    public function __construct(
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsRepository $pruefungsRepository
    ) {
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
    }

    /**
     * @Route("/api/pruefung")
     */
    public function jsonStudiPruefungAction() {
        $eingeloggterStudi = $this->getUser();
        $studiPruefungen = $this->studiPruefungsRepository->allByStudiHash(
            $eingeloggterStudi->getStudiHash()
        );
        $returnArray = [];
        foreach ($studiPruefungen as $studiPruefung) {
            $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
            $code = $pruefung->getFormat()->getCode();
            $datum = $pruefung->getPruefungsPeriode();
            $name = $pruefung->getFormat()->getTitel();
            $returnArray[] = [
                "typ"              => $code,
                "studiPruefungsId" => $studiPruefung->getId(),
                "name"             => $name,
                "datum"            => $datum->toIsoString(),
                "ergebnis"         => "TODO",
            ];
        }

        return new JsonResponse(
            ["pruefungen" => $returnArray]
        );

    }

}
