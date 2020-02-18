<?php

namespace Common\Domain;

trait HatEntityZeitstempelTrait
{
    private EntityZeitstempel $entityZeitstempel;

    public function getZeitstempel(): EntityZeitstempel {
        return $this->entityZeitstempel;
    }

    public function aktualisiereZeitstempel(): void {
        $this->entityZeitstempel = $this->entityZeitstempel->setzeGeandert();
    }

    private function erzeugeZeitstempel(): void {
        $this->entityZeitstempel = EntityZeitstempel::createErzeugungsZeitstempel();
    }

}