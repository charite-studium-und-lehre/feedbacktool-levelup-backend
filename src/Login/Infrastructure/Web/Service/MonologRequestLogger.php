<?php

namespace Login\Infrastructure\Web\Service;

use Monolog\Processor\ProcessorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class MonologRequestLogger implements EventSubscriberInterface, ProcessorInterface
{
    private RequestEvent $requestEvent;

    /** @return array<string, array<int, int|string>> */
    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 4096],
        ];
    }

    /**
     * @param array<string, array<string, string>> $record
     * @return array<string, array<string, array<string, string>|string>>
     */
    public function __invoke(array $record): array {
        if (isset($this->requestEvent)) {
            $record["extra"]["query"] = $this->requestEvent->getRequest()->query;
            $record["extra"]["headers"] = $this->requestEvent->getRequest()->headers;
            $record["extra"]["content"] = $this->requestEvent->getRequest()->getContent();
        }

        return $record;
    }

    public function onKernelRequest(RequestEvent $event): void {
        if ($event->isMasterRequest()) {
            $this->requestEvent = $event;
        }
    }
}
