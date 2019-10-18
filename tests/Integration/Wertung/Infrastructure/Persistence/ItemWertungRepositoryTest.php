<?php

namespace Tests\Integration\Wertung\Infrastructure\Persistence;

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
use Wertung\Domain\Wertung\RichtigFalschWeissnichtWertung;
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
        $itemWertungPunktzahl = ItemWertung::create(
            ItemWertungsId::fromInt(123),
            PruefungsItemId::fromString(456),
            StudiPruefungsId::fromInt(789),
            PunktWertung::fromPunktzahlUndSkala(Punktzahl::fromFloat(3.25),
                                                PunktSkala::fromMaxPunktzahl(Punktzahl::fromFloat(15.75)))
        );
        $itemWertungProzent = ItemWertung::create(
            ItemWertungsId::fromInt(789),
            PruefungsItemId::fromString(12),
            StudiPruefungsId::fromInt(5000),
            ProzentWertung::fromProzentzahl(Prozentzahl::fromFloat(.8746))
        );

        $itemWertungRichtigFalschWeissnicht = ItemWertung::create(
            ItemWertungsId::fromInt(456),
            PruefungsItemId::fromString(12),
            StudiPruefungsId::fromInt(5000),
            RichtigFalschWeissnichtWertung::fromPunktzahlen(
                Punktzahl::fromFloat(12),
                Punktzahl::fromFloat(15),
                Punktzahl::fromFloat(10)
            )
        );
        $itemWertungRichtigFalschWeissnicht->setKohortenWertung(RichtigFalschWeissnichtWertung::fromPunktzahlen(
            Punktzahl::fromFloat(10),
            Punktzahl::fromFloat(11),
            Punktzahl::fromFloat(12)
        ));

        $repo->add($itemWertungPunktzahl);
        $repo->add($itemWertungProzent);
        $repo->add($itemWertungRichtigFalschWeissnicht);
        $repo->flush();

        $this->refreshEntities($itemWertungPunktzahl, $itemWertungProzent);

        $this->assertCount(3, $repo->all());
        $object1 = $repo->byId(ItemWertungsId::fromInt(123));
        $object2 = $repo->byId(ItemWertungsId::fromInt(789));
        $object3 = $repo->byId(ItemWertungsId::fromInt(456));

        /** @var PunktWertung $object1Wertung */
        $object1Wertung = $object1->getWertung();

        $this->assertTrue($object1Wertung->equals($itemWertungPunktzahl->getWertung()));
        $this->assertTrue($object1->getStudiPruefungsId()->equals(StudiPruefungsId::fromInt(789)));
        $this->assertEquals(0.2063, $object1Wertung->getRelativeWertung());
        $this->assertEquals(3.25, $object1Wertung->getPunktzahl()->getValue());
        $this->assertTrue($object2->getWertung()->equals($itemWertungProzent->getWertung()));

        $this->assertTrue($object1->getPruefungsItemId()->equals($itemWertungPunktzahl->getPruefungsItemId()));

        /** @var ProzentWertung $object1Wertung */
        $object2Wertung = $object2->getWertung();
        $this->assertEquals($object2->getId()->getValue(), 789);
        $this->assertTrue($object2Wertung->equals($itemWertungProzent->getWertung()));

        /** @var RichtigFalschWeissnichtWertung $object3Wertung */
        $object3Wertung = $object3->getWertung();
        $this->assertEquals($object3->getId()->getValue(), 456);
        $this->assertTrue($object3Wertung->equals($itemWertungRichtigFalschWeissnicht->getWertung()));
        $this->assertEquals(37, $object3Wertung->getSkala()->getMaxPunktzahl()->getValue());
        $this->assertEquals(12, $object3->getKohortenWertung()
            ->getRichtigFalschWeissnichtWertung()->getPunktzahlWeissnicht()->getValue());

    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testByStudiPruefungsIdUndPruefungssItemId(ItemWertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $itemWertung = $repo->byStudiPruefungsIdUndPruefungssItemId(
            StudiPruefungsId::fromInt(789),
            PruefungsItemId::fromString(456),
            );
        $this->assertTrue($itemWertung->getId()->equals(ItemWertungsId::fromInt(123),));

        $itemWertung = $repo->byStudiPruefungsIdUndPruefungssItemId(
            StudiPruefungsId::fromInt(789),
            PruefungsItemId::fromString(457),
            );
        $this->assertNull($itemWertung);
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testAllByStudiPruefungsId(ItemWertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $itemWertungen = $repo->allByPruefungssItemId(PruefungsItemId::fromString(456));
        $this->assertCount(1, $itemWertungen);
    }

    /**
     * @dataProvider getAllRepositories
     */
    public function testDelete(ItemWertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(3, $repo->all());
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
