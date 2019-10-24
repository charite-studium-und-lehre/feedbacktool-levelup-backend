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

    public function __construct(
        StudiPruefungsRepository $studiPruefungsRepository,
        PruefungsRepository $pruefungsRepository
    ) {
        $this->studiPruefungsRepository = $studiPruefungsRepository;
        $this->pruefungsRepository = $pruefungsRepository;
    }

    /**
     * @Route("/api/pruefungen")
     */
    public function jsonStudiPruefungAction(StudiPruefungErgebnisService $ergebnisService) {
        $eingeloggterStudi = $this->getUser();
        if (!$eingeloggterStudi instanceof Studi) {
            return new JsonResponse(["pruefungen" => []], 200);
        }
        $studiPruefungen = $this->studiPruefungsRepository->allByStudiHash(
            $eingeloggterStudi->getStudiHash()
        );
        $returnArray = [];
        foreach ($studiPruefungen as $studiPruefung) {
            $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
            $pruefungsPeriode = $pruefung->getPruefungsPeriode();
            $name = $pruefung->getName();
            $returnArray[] = [
                "name"             => $name,
                "typ"              => $pruefung->getFormat()->getCode(),
                "format"           => $pruefung->getFormat()->getFormatAbstrakt(),
                "studiPruefungsId" => $studiPruefung->getId()->getValue(),
                "zeitsemester"     => $pruefungsPeriode->getZeitsemester()->getStandardStringLesbar(),
                "periodeCode"      => $pruefungsPeriode->toInt(),
                "periodeText"      => $pruefungsPeriode->getPeriodeBeschreibung(),
                "gesamtErgebnis"   =>
                    $ergebnisService->getErgebnisAlsJsonArray($studiPruefung),
            ];
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
        $studiPruefungsId = StudiPruefungsId::fromInt($studiPruefungsIdInt);
        $studiPruefung = $this->studiPruefungsRepository->byId($studiPruefungsId);
        $pruefung = $this->pruefungsRepository->byId($studiPruefung->getPruefungsId());
        $pruefungsPeriode = $pruefung->getPruefungsPeriode();

        $gesamtErgebnis = $ergebnisService->getErgebnisAlsJsonArray($studiPruefung);
        $einzelErgebnisse = $ergebnisService->getErgebnisDetailsAlsJsonArray($studiPruefung);

        $returnArray[] = [
            "typ"              => $pruefung->getFormat()->getCode(),
            "studiPruefungsId" => $studiPruefung->getId()->getValue(),
            "name"             => $pruefung->getName(),
            "format"           => $pruefung->getFormat()->getFormatAbstrakt(),
            "periodeCode"      => $pruefungsPeriode->toInt(),
            "periodeText"      => $pruefungsPeriode->getPeriodeBeschreibung(),
            "zeitsemester"     => $pruefungsPeriode->getZeitsemester()->getStandardStringLesbar(),
            "gesamtErgebnis"   => $gesamtErgebnis,
            "ergebnisse"       => $einzelErgebnisse,
        ];

        return new JsonResponse($returnArray, 200);

    }

}
