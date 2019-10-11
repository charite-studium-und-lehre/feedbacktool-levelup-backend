<?php

namespace EPA\Infrastructure\Controller\API;

use Common\Application\Command\CommandBus;
use EPA\Application\Command\SelbstBewertungErhoehenCommand;
use EPA\Application\Command\SelbstBewertungVermindernCommand;
use EPA\Domain\SelbstBewertungsTyp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelbstbewertungApiController extends AbstractController
{

    /**
     * @Route("/api/epa/selbstbewertung/erhoehen", name="api_selbstbewertung_erhoehen")
     */
    public function erhoeheSelbstbewertungAction(Request $request, CommandBus $commandBus, $vermindern = FALSE) {
        $eingeloggterStudi = $this->getUser();
        $epaId = $request->get("epaID");
        if ($request->get("typ") == "gemacht") {
            $typ = SelbstBewertungsTyp::GEMACHT;
        } elseif ($request->get("typ") == "zutrauen") {
            $typ = SelbstBewertungsTyp::ZUTRAUEN;
        } else {
            return new Response("Parameter 'typ' muss gegeben werden als 'gemacht' oder 'zutrauen'", 400);
        }

        if ($vermindern) {
            $command = new SelbstBewertungVermindernCommand();
        } else {
            $command = new SelbstBewertungErhoehenCommand();
        }

        $command->loginHash = $eingeloggterStudi->getLoginHash();
        $command->selbstBewertungsTyp = $typ;
        $command->epaId = $epaId;

        try {
            $commandBus->execute($command);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), 400);
        }

        return new Response("Erfolg", 200);
    }

    /**
     * @Route("/api/epa/selbstbewertung/vermindern", name="api_selbstbewertung_vermindern")
     */
    public function vermindereSelbstbewertungAction(Request $request, CommandBus $commandBus) {
        return $this->erhoeheSelbstbewertungAction($request, $commandBus, TRUE);

    }

}
