<?php

namespace Tests\Integration\EPA\Infrastructure\Persistence;

use Common\Domain\User\Email;
use EPA\Domain\FremdBewertung\AnfragerName;
use EPA\Domain\FremdBewertung\FremdBewerterName;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrage;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageDaten;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageId;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageKommentar;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageRepository;
use EPA\Domain\FremdBewertung\FremdBewertungsAnfrageTaetigkeiten;
use EPA\Infrastructure\Persistence\Filesystem\FileBasedSimpleFremdBewertungsAnfrageRepository;
use Studi\Domain\LoginHash;
use Tests\Integration\Common\DbRepoTestCase;
use Tests\Unit\Studi\Domain\NachnameTest;

final class FremdBewertungsAnfrageRepositoryTest extends DbRepoTestCase
{

    const LOGIN_HASH = '0062a008dbcd86fa8d0738e1f6e0f5daefe9fd2a7a9dddcacefd2a7a9dddcace';

    protected $dbRepoInterface = FremdBewertungsAnfrageRepository::class;

    public function getAllRepositories() {

        return [
            'file-based-repo' => [FileBasedSimpleFremdBewertungsAnfrageRepository::createTempFileRepo()],
            'db-repo'         => [$this->dbRepo],
        ];
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function kann_speichern_und_wiederholen(FremdBewertungsAnfrageRepository $repo) {

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

        $fremdbewertungsAnfrage1 = FremdBewertungsAnfrage::create(
            FremdBewertungsAnfrageId::fromInt(123),
            $loginHash,
            $fremdBewertungsAnfrageDaten,
            );

        $repo->add($fremdbewertungsAnfrage1);
        $repo->flush();
        $this->refreshEntities($fremdbewertungsAnfrage1);

        $this->assertCount(1, $repo->all());

        $fremdbewertungsAnfrage = $repo->byId(FremdBewertungsAnfrageId::fromInt(123));
        $this->assertTrue($fremdbewertungsAnfrage->getId()
                              ->equals($fremdbewertungsAnfrage1->getId()));
        $this->assertTrue($fremdbewertungsAnfrage->getLoginHash()
                              ->equals($fremdbewertungsAnfrage1->getLoginHash()));
        $this->assertTrue($fremdbewertungsAnfrage->getAnfrageDaten()
                              ->equals($fremdbewertungsAnfrage1->getAnfrageDaten()));
        $this->assertTrue($fremdbewertungsAnfrage->getAnfrageToken()
                              ->equals($fremdbewertungsAnfrage1->getAnfrageToken()));
    }

    /** @dataProvider getAllRepositories */
    public function testByToken(FremdBewertungsAnfrageRepository $repo) {
        $this->kann_speichern_und_wiederholen($repo);
        $anfrage = $repo->byId(FremdBewertungsAnfrageId::fromInt(123));
        $token = $anfrage->getAnfrageToken();

        $anfrageByToken = $repo->byToken($token);
        $this->assertNotNull($anfrageByToken);
        $this->assertTrue($anfrageByToken->getId()->equals(FremdBewertungsAnfrageId::fromInt(123)));
    }

    /**
     * @test
     * @dataProvider getAllRepositories
     */
    public function testDelete(FremdBewertungsAnfrageRepository $repo) {
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
