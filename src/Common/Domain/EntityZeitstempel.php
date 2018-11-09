<?php

namespace Common\Domain;

use DateTimeImmutable;

final class EntityZeitstempel
{

    /** @var \DateTimeImmutable */
    private $erzeugungsZeit;

    /** @var \DateTimeImmutable */
    private $aenderungsZeit = NULL;

    public static function createErzeugungsZeitstempel(): EntityZeitstempel {
        $entityZeitstempel = new self();
        $entityZeitstempel->erzeugungsZeit = new DateTimeImmutable();
        $entityZeitstempel->aenderungsZeit = NULL;

        return $entityZeitstempel;
    }

    public function setzeGeandert(): EntityZeitstempel {
        $entityZeitstempel = new self();
        $entityZeitstempel->erzeugungsZeit = $this->erzeugungsZeit;
        $entityZeitstempel->aenderungsZeit = new DateTimeImmutable();

        return $entityZeitstempel;
    }

    public function getErzeugungsZeit(): DateTimeImmutable {
        return $this->erzeugungsZeit;
    }

    public function getAenderungsZeit(): ?DateTimeImmutable {
        return $this->aenderungsZeit;
    }

    public function setzeErzeugungRelativ_fuerTest(int $sekunden) {
        $this->erzeugungsZeit = DateTimeImmutable::createFromMutable(
            (new \DateTime())
                ->add(new \DateInterval("PT$sekunden" . "S"))
        );
    }
}