<?php

namespace Tests\Integration\Wertung\Infrastructure\Persistence;

use Pruefung\Domain\PruefungsItem;
use Pruefung\Domain\PruefungsItemId;
use StudiPruefung\Domain\StudiPruefungsId;
use Tests\Integration\Common\DbRepoTestCase;
use Wertung\Domain\ItemWertung;
use Wertung\Domain\ItemWertungsId;
use Wertung\Domain\ItemWertungsRepository;
use Wertung\Domain\Skala\PunktSkala;
use Wertung\Domain\Wertung\ProzentWertung;
use Wertung\Domain\Wertung\Prozentzahl;
use Wertung\Domain\Wertung\PunktWertung;
use Wertung\Domain\Wertung\Punktzahl;
use Wertung\Infrastructure\Persistence\Filesystem\FileBasedSimpleItemWertungsRepository;

final class ItemWertungRepositoryTest extends DbRepoTestCase
{
    protected $dbRepoInterface = ItemWertungsRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleItemWertungsRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(ItemWertungsRepository $repo) {
        $itemWertung1 = ItemWertung::create(
            ItemWertungsId::fromInt(123),
            PruefungsItemId::fromInt(456),
            StudiPruefungsId::fromInt(789),
            PunktWertung::fromPunktzahlUndSkala(Punktzahl::fromFloat(3.25),
                                                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(15.75)))
        );
        $itemWertung2 = ItemWertung::create(
            ItemWertungsId::fromInt(789),
            PruefungsItemId::fromInt(12),
            StudiPruefungsId::fromInt(5000),
            ProzentWertung::fromProzentzahl(Prozentzahl::fromFloat(.8746))
        );

        $repo->add($itemWertung1);
        $repo->add($itemWertung2);
        $repo->flush();

        $this->refreshEntities($itemWertung1, $itemWertung2);

        $this->assertCount(2, $repo->all());
        $object1 = $repo->byId(ItemWertungsId::fromInt(123));
        $object2 = $repo->byId(ItemWertungsId::fromInt(789));

        /** @var PunktWertung $object1Wertung */
        $object1Wertung = $object1->getWertung();

        $this->assertTrue($object1Wertung->equals($itemWertung1->getWertung()));
        $this->assertTrue($object1->getStudiPruefungsId()->equals(StudiPruefungsId::fromInt(789)));
        $this->assertEquals(0.2063, $object1Wertung->getRelativeWertung());
        $this->assertEquals(3.25, $object1Wertung->getPunktzahl()->getValue());
        $this->assertTrue($object2->getWertung()->equals($itemWertung2->getWertung()));

        $this->assertTrue($object1->getPruefungsItemId()->equals($itemWertung1->getPruefungsItemId()));
        $this->assertEquals($object2->getId()->getValue(), 789);
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testByStudiPruefungsIdUndPruefungssItemId(ItemWertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $itemWertung = $repo->byStudiPruefungsIdUndPruefungssItemId(
            StudiPruefungsId::fromInt(789),
            PruefungsItemId::fromInt(456),
        );
        $this->assertTrue($itemWertung->getId()->equals(ItemWertungsId::fromInt(123),));

        $itemWertung = $repo->byStudiPruefungsIdUndPruefungssItemId(
            StudiPruefungsId::fromInt(789),
            PruefungsItemId::fromInt(457),
            );
        $this->assertNull($itemWertung);
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testDelete(ItemWertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(2, $repo->all());
        foreach ($repo->all() as $entity) {
            $repo->delete($entity);
        }
        $repo->flush();
        $this->assertCount(0, $repo->all());
    }

    protected function clearDatabase(): void {
        // use $this->deleteIdsFromDB or $this->emptyRepositoryWithTruncate()
        $this->emptyRepositoryWithTruncate();
    }

}
