<?php

declare(strict_types=1);

namespace LevelUpCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029180339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pruefung_frage (id VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', pruefungsItemId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', nummer INT NOT NULL, text VARCHAR(2000) NOT NULL, INDEX pruefungsItemId (pruefungsItemId), INDEX fragenNummer (nummer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pruefung_frage_antwort (id VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', fragenId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', antwortCode VARCHAR(3) NOT NULL COMMENT \'(DC2Type:antwortCode)\', istRichtig TINYINT(1) NOT NULL, text VARCHAR(550) NOT NULL, INDEX fragenId (fragenId), INDEX istRichtig (istRichtig), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pruefung_itemWertung ADD antwortCode VARCHAR(3) DEFAULT NULL COMMENT \'(DC2Type:antwortCode)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pruefung_frage');
        $this->addSql('DROP TABLE pruefung_frage_antwort');
        $this->addSql('ALTER TABLE pruefung_itemWertung DROP antwortCode');
    }
}
