<?php

namespace SSO\Domain;

use Studi\Domain\Studi;

interface EingeloggterStudiService {
    public function getEingeloggterStudi(): ?Studi;
}
