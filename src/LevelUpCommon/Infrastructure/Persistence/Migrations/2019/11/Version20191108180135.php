<?php

declare(strict_types=1);

namespace LevelUpCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191108180135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//        $this->addSql('ALTER TABLE epa_fremdBewertung ADD studi_vollerName VARCHAR(100) NOT NULL, ADD studi_email VARCHAR(60) NOT NULL, CHANGE anfrage_fremdbewertungsanfragetaetigkeiten anfrageTaetigkeiten VARCHAR(2000) DEFAULT NULL COMMENT \'(DC2Type:fremdBewertungsAnfrageTaetigkeiten)\', CHANGE anfrage_fremdbewertungsanfragekommentar anfrageKommentar VARCHAR(2000) DEFAULT NULL COMMENT \'(DC2Type:fremdBewertungsAnfrageKommentar)\', CHANGE anfrage_datum datum DATE NOT NULL, CHANGE anfrage_vollername bewerter_vollerName VARCHAR(100) NOT NULL, CHANGE anfrage_email bewerter_email VARCHAR(60) NOT NULL');
//        $this->addSql('ALTER TABLE epa_fremdBewertung_anfrage ADD studi_vollerName VARCHAR(100) NOT NULL, ADD studi_email VARCHAR(60) NOT NULL, CHANGE fremdbewertungsanfragetaetigkeiten anfrageTaetigkeiten VARCHAR(2000) DEFAULT NULL COMMENT \'(DC2Type:fremdBewertungsAnfrageTaetigkeiten)\', CHANGE fremdbewertungsanfragekommentar anfrageKommentar VARCHAR(2000) DEFAULT NULL COMMENT \'(DC2Type:fremdBewertungsAnfrageKommentar)\', CHANGE vollername bewerter_vollerName VARCHAR(100) NOT NULL, CHANGE email bewerter_email VARCHAR(60) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE epa_fremdBewertung ADD anfrage_vollerName VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD anfrage_email VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP bewerter_vollerName, DROP bewerter_email, DROP studi_vollerName, DROP studi_email, CHANGE anfragetaetigkeiten anfrage_fremdBewertungsAnfrageTaetigkeiten VARCHAR(2000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:fremdBewertungsAnfrageTaetigkeiten)\', CHANGE anfragekommentar anfrage_fremdBewertungsAnfrageKommentar VARCHAR(2000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:fremdBewertungsAnfrageKommentar)\', CHANGE datum anfrage_datum DATE NOT NULL');
        $this->addSql('ALTER TABLE epa_fremdBewertung_anfrage ADD vollerName VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD email VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP bewerter_vollerName, DROP bewerter_email, DROP studi_vollerName, DROP studi_email, CHANGE anfragetaetigkeiten fremdBewertungsAnfrageTaetigkeiten VARCHAR(2000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:fremdBewertungsAnfrageTaetigkeiten)\', CHANGE anfragekommentar fremdBewertungsAnfrageKommentar VARCHAR(2000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:fremdBewertungsAnfrageKommentar)\'');
    }
}
