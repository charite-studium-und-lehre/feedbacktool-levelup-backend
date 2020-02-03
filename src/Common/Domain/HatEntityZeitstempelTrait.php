<?php

namespace Common\Domain;

trait HatEntityZeitstempelTrait
{
    private \Common\Domain\EntityZeitstempel $entityZeitstempel;

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