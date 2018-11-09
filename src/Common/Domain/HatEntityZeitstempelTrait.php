<?php

namespace Common\Domain;

trait HatEntityZeitstempelTrait
{
    /** @var EntityZeitstempel */
    private $entityZeitstempel;

    public function getZeitstempel(): EntityZeitstempel {
        return $this->entityZeitstempel;
    }

    public function aktualisiereZeitstempel() {
        $this->entityZeitstempel = $this->entityZeitstempel->setzeGeandert();
    }

    private function erzeugeZeitstempel() {
        $this->entityZeitstempel = EntityZeitstempel::createErzeugungsZeitstempel();
    }

}