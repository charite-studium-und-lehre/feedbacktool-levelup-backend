<?php

namespace Common\Domain;

use DateInterval;
use DateTime;
use DateTimeImmutable;

final class EntityZeitstempel
{

    private \DateTimeImmutable $erzeugungsZeit;

    private ?\DateTimeImmutable $aenderungsZeit = NULL;

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

    public function setzeErzeugungRelativ_fuerTest(int $sekunden): void {
        $this->erzeugungsZeit = DateTimeImmutable::createFromMutable(
            (new DateTime())
                ->add(new DateInterval("PT$sekunden" . "S"))
        );
    }

    public function erzeugungAelterAlsSekunden(int $sekunden): bool {
        return $this->zeitstempelAelterAlsSekunden($this->erzeugungsZeit, $sekunden);
    }

    private function zeitstempelAelterAlsSekunden(DateTimeImmutable $zeitstempel, int $sekunden): bool {
        $dateTimePast = new \DateTime('now');
        $dateTimePast->modify("- $sekunden seconds");
        return $zeitstempel < $dateTimePast;
    }
}