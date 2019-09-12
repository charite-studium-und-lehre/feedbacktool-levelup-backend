<?php

namespace SSO\Infrastructure\Web\Service;

use SSO\Domain\EingeloggterStudiService;
use Studi\Domain\Studi;
use Studi\Domain\StudiRepository;

class WebEingeloggterStudiService implements EingeloggterStudiService {
    /** @var StudiRepository */
    private $studiRepository;

    public function getEingeloggterStudi(): ?Studi {
        return $this->studiRepository->byHash('$argon2i$v=19$m=4096,t=10,p=2$a01HNWM4RzVIQWI1S0NudA$k88hkG9PeJoKwZU4aWsRAGPFXF88vMplFPYUVho8MeU');
    }
}
