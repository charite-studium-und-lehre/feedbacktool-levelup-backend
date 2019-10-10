<?php

namespace EPA\Infrastructure\Controller\API;

use Common\Application\Command\CommandBus;
use EPA\Application\Command\SelbstBewertungErhoehenCommand;
use EPA\Application\Command\SelbstBewertungVermindernCommand;
use EPA\Domain\SelbstBewertungsTyp;
use EPA\Domain\Service\EpasFuerStudiService;
use SSO\Domain\EingeloggterStudiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EPAStatusApiController extends AbstractController
{

    /** @var EingeloggterStudiService */
    private $eingeloggterStudiService;

    public function __construct(EingeloggterStudiService $eingeloggterStudiService) {
        $this->eingeloggterStudiService = $eingeloggterStudiService;
    }

    /**
     * @Route("/api/epa/meine", name="api_selbstbewertung_erhoehen")
     */
    public function meineEpas(EpasFuerStudiService $epasFuerStudiService) {
        $epasFuerStudiService->getEpaStudiData();

    }

    /**
     * @Route("/api/epa/selbstbewertung/vermindern", name="api_selbstbewertung_vermindern")
     */
    public function vermindereSelbstbewertungAction(Request $request, CommandBus $commandBus) {
        return $this->erhoeheSelbstbewertungAction($request, $commandBus, TRUE);

    }

}
