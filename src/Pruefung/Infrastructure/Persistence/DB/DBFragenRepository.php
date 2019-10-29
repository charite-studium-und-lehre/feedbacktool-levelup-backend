<?php

namespace Pruefung\Infrastructure\Persistence\DB;

use Common\Infrastructure\Persistence\DB\DDDDoctrineRepoTrait;
use Pruefung\Domain\FrageAntwort\Frage;
use Pruefung\Domain\FrageAntwort\FragenId;
use Pruefung\Domain\FrageAntwort\FragenRepository;

final class DBFragenRepository implements FragenRepository
{
    use DDDDoctrineRepoTrait;

    public function delete(Frage $object): void {
        $this->abstractDelete($object);
    }

    public function add(Frage $pruefung): void {
        $this->abstractAdd($pruefung);
    }

    public function byId(FragenId $id): ?Frage {
        return $this->abstractById($id->getValue());
    }

    public function nextIdentity(): FragenId {
        return FragenId::fromString($this->abstractNextIdentityAsInt());
    }

}