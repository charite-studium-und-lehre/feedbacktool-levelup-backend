<?php

namespace Demo\Infrastructure\UserInterface\Web;

use App\Controller\TokenAuthenticatedController;
use Demo\Infrastructure\Persistence\AbstractJsonDemoData;
use Demo\Infrastructure\Persistence\EpasDemoData;
use Demo\Infrastructure\Persistence\EpasFremdBewertungenData;
use Demo\Infrastructure\Persistence\MCFragenDemoData;
use Demo\Infrastructure\Persistence\MeilensteineJsonDemoData;
use Demo\Infrastructure\Persistence\PruefungenDemoData;
use Demo\Infrastructure\Persistence\StammdatenJsonDemoData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DemoControllerSubscriber implements EventSubscriberInterface
{
    /** @var StammdatenJsonDemoData */
    private $stammdatenData;

    /** @var MeilensteineJsonDemoData */
    private $meilensteineData;

    /** @var PruefungenDemoData */
    private $pruefungenData;

    /** @var EpasDemoData */
    private $epasData;

    /** @var EpasFremdBewertungenData */
    private $epasFremdBewertungenData;

    /** @var MCFragenDemoData */
    private $mcFragenData;

    public function __construct(
        StammdatenJsonDemoData $stammdatenData,
        MeilensteineJsonDemoData $meilensteineData,
        PruefungenDemoData $pruefungenData,
        EpasDemoData $epasData,
        EpasFremdBewertungenData $epasFremdBewertungenData,
        MCFragenDemoData $mcFragenData
    ) {
        $this->stammdatenData = $stammdatenData;
        $this->meilensteineData = $meilensteineData;
        $this->pruefungenData = $pruefungenData;
        $this->epasData = $epasData;
        $this->epasFremdBewertungenData = $epasFremdBewertungenData;
        $this->mcFragenData = $mcFragenData;
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event) {
        $request = $event->getRequest();
        if (false &&!$this->isDemo($request)) {
            return;
        }
        /** @var AbstractJsonDemoData $dataClass */
        $dataClass = NULL;

        switch ($request->getPathInfo()) {
            case "/api/stammdaten":
                $dataClass = $this->stammdatenData;
                break;
            case "/api/meilensteine":
            case "/api/studienfortschritt":
                $dataClass = $this->meilensteineData;
                break;
            case "/api/pruefungen":
                $dataClass = $this->pruefungenData;
                break;
            case "/api/epas/bewertungen":
                $dataClass = $this->epasFremdBewertungenData;
                break;
            case "/api/epas":
                $dataClass = $this->epasData;
                break;
            case "/api/pruefungen/680/fragen":
                $dataClass = $this->mcFragenData;
                break;

            default:
                throw new \Exception("Nicht gefunden: " . $request->getPathInfo());
        }
        $event->stopPropagation();
        $event->setController($dataClass->getController());

    }

    private function isDemo(Request $request) {
        return strstr($request->headers->get("referer"), "demo") !== FALSE
            || $request->get("demo") == TRUE;

    }

}

