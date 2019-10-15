<?php

namespace StudiPruefung\Infrastructure\Api\Controller;

use Pruefung\Domain\PruefungsRepository;
use StudiPruefung\Domain\Service\StudiPruefungErgebnisService;
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
    public function jsonStudiPruefungAction(StudiPruefungErgebnisService $ergebnisService) {
        $eingeloggterStudi = $this->getUser();
        $studiPruefungen = $this->studiPruefungsRepository->allByStudiHash(
            $eingeloggterStudi->getStudiHash()
        );
        $returnArray = [];
        foreach ($studiPruefungen as $studiPruefung) {
            $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
            $pruefungsPeriode = $pruefung->getPruefungsPeriode();
            $name = $pruefung->getFormat()->getTitel() . " " . $pruefungsPeriode->getPeriodeBeschreibung();
            $returnArray[] = [
                "name"             => $name,
                "typ"              => $pruefung->getFormat()->getCode(),
                "format"           => $pruefung->getFormat()->getFormatAbstrakt(),
                "studiPruefungsId" => $studiPruefung->getId()->getValue(),
                "periodeCode"      => $pruefungsPeriode->toInt(),
                "periodeText"      => $pruefungsPeriode->toInt(),
                "ergebnis"         =>
                    $ergebnisService->getErgebnisAlsJsonArray(
                        $pruefung,
                        $studiPruefung->getId()
                    ),
            ];
        }

        return new JsonResponse(
            ["pruefungen" => $returnArray]
        );

    }

}
