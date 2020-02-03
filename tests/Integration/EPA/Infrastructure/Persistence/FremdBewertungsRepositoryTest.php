<?php

namespace Tests\Integration\EPA\Infrastructure\Persistence;

use Common\Domain\User\Email;
use EPA\Domain\EPA;
use EPA\Domain\EPABewertung;
use EPA\Domain\FremdBewertung\AnfragerName;
use EPA\Domain\FremdBewertung\FremdBewerterName;
use EPA\Domain\FremdBewertung\FremdBewertung;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageDaten;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageKommentar;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageTaetigkeiten;
use EPA\Domain\FremdBewertung\FremdBewertungsId;
use EPA\Domain\FremdBewertung\FremdBewertungsRepository;
use EPA\Infrastructure\Persistence\Filesystem\FileBasedSimpleFremdBewertungsRepository;
use Studi\Domain\LoginHash;
use Tests\Integration\Common\DbRepoTestCase;

final class FremdBewertungsRepositoryTest extends DbRepoTestCase
{

    const LOGIN_HASH = '0062a008dbcd86fa8d0738e1f6e0f5daefe9fd2a7a9dddcacefd2a7a9dddcace';

    protected $dbRepoInterface = FremdBewertungsRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleFremdBewertungsRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(FremdBewertungsRepository $repo) {

        $fremdBewerterName = FremdBewerterName::fromString("Prof. Ingrid Meyer-Lüdenscheid");
        $email = Email::fromString("ingrid.meyer-luedenscheid@charite.de");
        $studiName = AnfragerName::fromString("Petra Meyer-Lüdenscheid");
        $studiEmail = Email::fromString("petra@luedenscheid.de");

        $fremdBewertungsAnfrageTaetigkeiten = FremdBewertungsAnfrageTaetigkeiten::fromString("Ich hätte gerne eine Bewertung zu:
* Blut abnehmen
* Anamnese

ich war bei Ihnen in der Famulatur");
        $fremdBewertungsAnfrageKommentar =
            FremdBewertungsAnfrageKommentar::fromString("Ich freue mich über eine schnelle Bearbeitung...");

        $fremdBewertungsAnfrageDaten = FremdBewertungsAnfrageDaten::fromDaten(
            $fremdBewerterName,
            $email,
            $studiName,
            $studiEmail,
            $fremdBewertungsAnfrageTaetigkeiten,
            $fremdBewertungsAnfrageKommentar
        );
        $loginHash = LoginHash::fromString(self::LOGIN_HASH);

        $bewertungen = [
            EPABewertung::fromValues(4, EPA::fromInt(111)),
            EPABewertung::fromValues(4, EPA::fromInt(112)),
            EPABewertung::fromValues(4, EPA::fromInt(113)),
            EPABewertung::fromValues(4, EPA::fromInt(311)),
        ];

        $fremdbewertung1 = FremdBewertung::create(
            FremdBewertungsId::fromInt(123),
            $loginHash,
            $fremdBewertungsAnfrageDaten,
            $bewertungen
        );

        $repo->add($fremdbewertung1);
        $repo->flush();
        $this->refreshEntities($fremdbewertung1);

        $this->assertCount(1, $repo->all());

        $fremdbewertung = $repo->byId(FremdBewertungsId::fromInt(123));
        $this->assertTrue($fremdbewertung->getId()
                              ->equals($fremdbewertung1->getId()));
        $this->assertTrue($fremdbewertung->getLoginHash()
                              ->equals($fremdbewertung1->getLoginHash()));
        $this->assertTrue($fremdbewertung->getAnfrageDaten()
                              ->equals($fremdbewertung1->getAnfrageDaten()));
        $this->assertTrue($fremdbewertung->getBewertungsDatum()
                              ->equals($fremdbewertung->getBewertungsDatum()));
        $this->assertCount(4, $fremdbewertung->getBewertungen());
        $this->assertEquals($fremdbewertung->getBewertungen(), $fremdbewertung1->getBewertungen());
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(FremdBewertungsRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $this->assertCount(1, $repo->all());
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
