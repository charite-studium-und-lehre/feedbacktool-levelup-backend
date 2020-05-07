<?php

namespace Login\Infrastructure\Web\Service;

use Monolog\Processor\ProcessorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class MonologRequestLogger implements EventSubscriberInterface, ProcessorInterface
{

    private array $data = [];

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 4096],
        ];
    }

    public function __invoke(array $record): array {
        $record["extra"] += $this->data;

        return $record;
    }

    public function onKernelRequest(RequestEvent $event) {
        if ($event->isMasterRequest()) {
            $this->data["SERVER"] = $event->getRequest()->server->all();
            $this->data["SERVER"]['REMOTE_ADDR'] = $event->getRequest()->getClientIp();
            $this->data["REQUEST"] = $event->getRequest()->request->all();
            $this->data["HEADERS"] = $event->getRequest()->headers->all();
            $this->data["ATTRIBUTES"] = $event->getRequest()->attributes->all();
        }
    }
}
