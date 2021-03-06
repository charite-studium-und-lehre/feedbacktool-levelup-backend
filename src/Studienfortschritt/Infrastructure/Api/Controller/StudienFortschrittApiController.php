<?php

namespace Studienfortschritt\Infrastructure\Api\Controller;

use LevelUpCommon\Infrastructure\UserInterface\Web\Controller\BaseController;
use Studi\Domain\Studi;
use Studienfortschritt\Domain\FortschrittsItem;
use Studienfortschritt\Domain\Service\StudienFortschrittZusammenstellungsService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudienFortschrittApiController extends BaseController
{

    private StudienFortschrittZusammenstellungsService $meilensteinExportService;

    public function __construct(StudienFortschrittZusammenstellungsService $meilensteinExportService) {
        $this->meilensteinExportService = $meilensteinExportService;
    }

    /**
     * @Route("/api/meilensteine")
     * @Route("/api/studienfortschritt", name="studienfortschritt")
     */
    public function jsonMeilensteineAction(): Response {
        session_write_close();
        $eingeloggterStudi = $this->getUser();
        if (!$eingeloggterStudi instanceof Studi) {
            return new Response("Nicht als 'echter' Studi eingeloggt (switchUser).", 403);
        }
        $meilensteine = $this->meilensteinExportService->alleFortschrittsItemsFuerStudi(
            $eingeloggterStudi->getStudiHash()
        );
        $studiCodesZuMeilenstein = [];
        foreach ($meilensteine as $meilenstein) {
            $studiCodesZuMeilenstein[$meilenstein->getCode()] = $meilenstein;
        }

        foreach (FortschrittsItem::FORTSCHRITT_KUERZEL_ZU_CODE as $code) {
            if (array_key_exists($code, $studiCodesZuMeilenstein)) {
                $meilenstein = $studiCodesZuMeilenstein[$code];
            } else {
                $meilenstein = FortschrittsItem::fromCode($code);
            }

            $meilensteinArray[] = [
                "code"             => $code,
                "kuerzel"          => $meilenstein->getKuerzel(),
                "beschreibung"     => $meilenstein->getTitel(),
                "fachsemester"     => $meilenstein->getFachsemester(),
                "erfuellt"         => array_key_exists($code, $studiCodesZuMeilenstein),
                "studiPruefungsId" => $meilenstein->getStudiPruefungsId()
                    ? $meilenstein->getStudiPruefungsId()->getValue()
                    : NULL,
                "format"           => $meilenstein->getPruefungsTyp(),
            ];
        }

        return new JsonResponse(
            ["meilensteine" => $meilensteinArray]
        );

    }

}
