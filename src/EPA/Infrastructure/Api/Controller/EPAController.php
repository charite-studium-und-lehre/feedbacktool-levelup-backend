<?php

namespace EPA\Infrastructure\Api\Controller;

use Common\Application\Command\CommandBus;
use EPA\Application\Command\SelbstBewertungErhoehenCommand;
use EPA\Domain\SelbstBewertungsTyp;
use Exception;
use SSO\Domain\EingeloggterStudiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EPAController extends AbstractController
{

    /** @var EingeloggterStudiService */
    private $eingeloggterStudiService;

    public function __construct(EingeloggterStudiService $eingeloggterStudiService) {
        $this->eingeloggterStudiService = $eingeloggterStudiService;
    }

    /**
     * @Route("/api/epa/selbstbewertung/erhoehen")
     */
    public function erhoeheSelbstbewertungAction(Request $request, CommandBus $commandBus) {
        $eingeloggterStudi = $this->eingeloggterStudiService->getEingeloggterStudi();
        $epaId = $request->get("epaID");
        $typ = $request->get("typ") == "gemacht"
            ? SelbstBewertungsTyp::GEMACHT
            : SelbstBewertungsTyp::ZUTRAUEN;

        $erhoehenCommand = new SelbstBewertungErhoehenCommand();
        $erhoehenCommand->studiHash = $eingeloggterStudi->getStudiHash();
        $erhoehenCommand->selbstBewertungsTyp = $typ;
        $erhoehenCommand->epaId = $epaId;

        $commandBus->execute($erhoehenCommand);
        try {
        } catch (Exception $e) {
            return new Response($e->getMessage(), 400);
        }

        return new Response("", 200);
    }

}
