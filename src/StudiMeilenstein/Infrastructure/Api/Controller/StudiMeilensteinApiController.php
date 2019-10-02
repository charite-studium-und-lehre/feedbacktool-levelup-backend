<?php

namespace StudiMeilenstein\Infrastructure\Api\Controller;

use SSO\Domain\EingeloggterStudiService;
use StudiMeilenstein\Domain\Meilenstein;
use StudiMeilenstein\Domain\Service\MeilensteinExportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StudiMeilensteinApiController extends AbstractController
{

    /** @var EingeloggterStudiService */
    private $eingeloggterStudiService;

    /** @var MeilensteinExportService */
    private $meilensteinExportService;

    public function __construct(
        EingeloggterStudiService $eingeloggterStudiService,
        MeilensteinExportService $meilensteinExportService
    ) {
        $this->eingeloggterStudiService = $eingeloggterStudiService;
        $this->meilensteinExportService = $meilensteinExportService;
    }

    /**
     * @Route("/api/meilensteine")
     */
    public function jsonMeilensteineAction() {
        $eingeloggterStudi = $this->eingeloggterStudiService->getEingeloggterStudi();
        $meilensteine = $this->meilensteinExportService->alleMeilensteineFuerStudi(
            $eingeloggterStudi->getStudiHash()
        );
        $studiCodes = [];
        foreach ($meilensteine as $meilenstein) {
            $studiCodes[] = $meilenstein->getCode();
        }

        foreach (Meilenstein::MEILENSTEINE_KUERZEL_ZU_CODE as $code) {
            $meilenstein = Meilenstein::fromCode($code);
            $meilensteinArray[] = [
                "code"             => $code,
                "kuerzel"          => $meilenstein->getKuerzel(),
                "beschreibung"     => $meilenstein->getTitel(),
                "fachsemester"     => $meilenstein->getFachsemester(),
                "erfuellt"         => in_array($code, $studiCodes),
                "studiPruefungsId" => $meilenstein->getStudiPruefungsId(),
            ];
        }

        return new JsonResponse(
            ["meilensteine" => $meilensteinArray]
        );

    }

}
