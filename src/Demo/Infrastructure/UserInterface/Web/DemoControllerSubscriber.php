<?php

namespace Demo\Infrastructure\UserInterface\Web;

use App\Controller\TokenAuthenticatedController;
use Demo\Infrastructure\Persistence\AbstractJsonDemoData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DemoControllerSubscriber implements EventSubscriberInterface
{
    /** @var AbstractJsonDemoData[] */
    private $demoDataClasses;

    public function __construct(iterable $demoDataClasses) {
        $this->demoDataClasses = $demoDataClasses;
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
        $pathInfo = $request->getPathInfo();

        foreach ($this->demoDataClasses as $demoDataClass) {
            if ($demoDataClass->isResponsibleFor($pathInfo)) {
                $event->stopPropagation();
                $event->setController($demoDataClass->getController($pathInfo));
                return;
            }
        }

        throw new \Exception("Nicht gefunden: " . $pathInfo);
    }

    private function isDemo(Request $request) {
        return strstr($request->headers->get("referer"), "demo") !== FALSE
            || $request->get("demo") == TRUE;

    }

}
