<?php

namespace Demo\Infrastructure\UserInterface\Web;

use App\Controller\TokenAuthenticatedController;
use Demo\Infrastructure\Persistence\AbstractJsonDemoData;
use Demo\Infrastructure\Persistence\EpasDemoData;
use Demo\Infrastructure\Persistence\EpasFremdBewertungenData;
use Demo\Infrastructure\Persistence\LogoutData;
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

    /** @var LogoutData */
    private $logoutData;

    public function __construct(
        StammdatenJsonDemoData $stammdatenData,
        MeilensteineJsonDemoData $meilensteineData,
        PruefungenDemoData $pruefungenData,
        EpasDemoData $epasData,
        EpasFremdBewertungenData $epasFremdBewertungenData,
        MCFragenDemoData $mcFragenData,
        LogoutData $logoutData
    ) {
        $this->stammdatenData = $stammdatenData;
        $this->meilensteineData = $meilensteineData;
        $this->pruefungenData = $pruefungenData;
        $this->epasData = $epasData;
        $this->epasFremdBewertungenData = $epasFremdBewertungenData;
        $this->mcFragenData = $mcFragenData;
        $this->logoutData = $logoutData;
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event) {
        $request = $event->getRequest();
        if (!$this->isDemo($request)) {
            return;
        }
        /** @var AbstractJsonDemoData $dataClass */
        $dataClass = NULL;

        $pathInfoOrig = $request->getPathInfo();
        $pathInfo = preg_replace("/\/[0-9]+/", "", $pathInfoOrig);
        
        $params = [];
        switch ($pathInfo) {
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
            case "/api/pruefungen/fragen":
                $dataClass = $this->mcFragenData;
                preg_match("/\/[0-9]+\//", $pathInfoOrig, $matches);
                if ($matches[0]) {
                    $studiPruefungsId = str_replace("/", "", $matches[0]);
                }
                $params = ["studiPruefungsId" => $studiPruefungsId];
                break;
            case "/logout";
            case "/logoutFromSSO";
                $dataClass = $this->logoutData;
                break;
            default:
                throw new \Exception("Nicht gefunden: " . $request->getPathInfo());
        }
        $event->stopPropagation();
        $event->setController($dataClass->getController($params));

    }

    private function isDemo(Request $request) {
        return strstr($request->headers->get("referer"), "demo") !== FALSE
            || $request->get("demo") == TRUE;

    }

}

