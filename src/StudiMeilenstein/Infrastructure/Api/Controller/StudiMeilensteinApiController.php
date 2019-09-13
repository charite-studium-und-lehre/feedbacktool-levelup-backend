<?php
namespace StudiMeilenstein\Infrastructure\Api\Controller;

use SSO\Domain\EingeloggterStudiService;
use StudiMeilenstein\Domain\Meilenstein;
use StudiMeilenstein\Domain\StudiMeilensteinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StudiMeilensteinApiController extends AbstractController{

    /** @var StudiMeilensteinRepository */
    private $studiMeilensteinRepository;

    /** @var EingeloggterStudiService */
    private $eingeloggterStudiService;

    public function __construct(
        StudiMeilensteinRepository $studiMeilensteinRepository,
        EingeloggterStudiService $eingeloggterStudiServcie
    ) {
        $this->studiMeilensteinRepository = $studiMeilensteinRepository;
        $this->eingeloggterStudiService = $eingeloggterStudiServcie;
    }

    /**
     * @Route("/api/meilensteine")
     */
    public function jsonMeilensteineAction() {
        $eingeloggterStudi = $this->eingeloggterStudiService->getEingeloggterStudi();
        $meilensteine = $this->studiMeilensteinRepository->allByStudiHash($eingeloggterStudi->getStudiHash());
        $studiCodes = [];
        foreach ($meilensteine as $meilenstein) {
            $studiCodes[] = $meilenstein->getMeilenstein()->getCode();
        }
        // TODO: mit echten Prüfungen ersetzen;
        $studiCodes[] = 401;
        $studiCodes[] = 402;
        $studiCodes[] = 403;
        $studiCodes[] = 404;
        $studiCodes[] = 406;

        $studiCodes[] = 502;
        $studiCodes[] = 504;

        foreach (Meilenstein::MEILENSTEINE_KUERZEL_ZU_CODE as $code) {
            $meilenstein = Meilenstein::fromCode($code);
            $meilensteinArray[] = [
                "code" => $code,
                "kuerzel" => $meilenstein->getKuerzel(),
                "beschreibung" => $meilenstein->getTitel(),
                "fachsemester" => $meilenstein->getFachsemester(),
                "erfuellt" => in_array($code, $studiCodes),
            ];
        }
        return new JsonResponse(
            ["meilensteine" => $meilensteinArray]
        );


    }

}
