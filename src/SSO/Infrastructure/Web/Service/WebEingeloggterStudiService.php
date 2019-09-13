<?php

namespace SSO\Infrastructure\Web\Service;

use SSO\Domain\EingeloggterStudiService;
use Studi\Domain\Studi;
use Studi\Domain\StudiHash;
use Studi\Domain\StudiRepository;

class WebEingeloggterStudiService implements EingeloggterStudiService
{
    /** @var StudiRepository */
    private $studiRepository;

    public function __construct(StudiRepository $studiRepository) {
        $this->studiRepository = $studiRepository;
    }

    public function getEingeloggterStudi(): ?Studi {
        return $this->studiRepository->all()[0];
    }
}
