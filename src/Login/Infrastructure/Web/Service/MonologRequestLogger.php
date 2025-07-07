<?php

namespace Login\Infrastructure\Web\Service;

use Monolog\LogRecord;
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
     * @return array<mixed>
     */
    public function __invoke(LogRecord $record): LogRecord {
        if (isset($this->requestEvent)) {
            $record["extra"]["query"] = (array) $this->requestEvent->getRequest()->query;
            $record["extra"]["headers"] = (array) $this->requestEvent->getRequest()->headers;
            $record["extra"]["content"] = (array) $this->requestEvent->getRequest()->getContent();
        }

        return $record;
    }

    public function onKernelRequest(RequestEvent $event): void {
        if ($event->isMasterRequest()) {
            $this->requestEvent = $event;
        }
    }
}
