<?php

namespace Pruefung\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\FrageAntwort\Antwort;
use Pruefung\Domain\FrageAntwort\AntwortId;
use Pruefung\Domain\FrageAntwort\AntwortRepository;
use Pruefung\Domain\FrageAntwort\FragenId;

final class DBAntwortRepository implements AntwortRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(Antwort $object): void {
        $this->abstractDelete($object);
    }

    public function add(Antwort $pruefung): void {
        $this->abstractAdd($pruefung);
    }

    public function byId(AntwortId $id): ?Antwort {
        return $this->abstractById($id->getValue());
    }

    public function nextIdentity(): AntwortId {
        return AntwortId::fromString($this->abstractNextIdentityAsInt());
    }

    /** @return Antwort[] */
    public function allByFragenId(FragenId $fragenId): array {
        return $this->doctrineRepo->findBy(
            ["fragenId" => $fragenId]
        );
    }
}