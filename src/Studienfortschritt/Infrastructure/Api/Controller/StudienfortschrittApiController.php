<?php

namespace Studienfortschritt\Infrastructure\Api\Controller;

use SSO\Domain\EingeloggterStudiService;
use Studi\Domain\Studi;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\Service\StudienFortschrittExportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudienfortschrittApiController extends AbstractController
{

    /** @var StudienFortschrittExportService */
    private $meilensteinExportService;

    public function __construct(StudienFortschrittExportService $meilensteinExportService) {
        $this->meilensteinExportService = $meilensteinExportService;
    }

    /**
     * @Route("/api/meilensteine")
     * @Route("/api/studienfortschritt", name="studienfortschritt")
     */
    public function jsonMeilensteineAction() {
        $eingeloggterStudi = $this->getUser();
        if (!$eingeloggterStudi instanceof Studi) {
            return new Response("Nicht als 'echter' Studi eingeloggt (switchUser).", 403);
        }
        $meilensteine = $this->meilensteinExportService->alleFortschrittsItemsFuerStudi(
            $eingeloggterStudi->getStudiHash()
        );
        $studiCodes = [];
        foreach ($meilensteine as $meilenstein) {
            $studiCodes[] = $meilenstein->getCode();
        }

        foreach (FortschrittsItem::FORTSCHRITT_KUERZEL_ZU_CODE as $code) {
            $meilenstein = FortschrittsItem::fromCode($code);
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
