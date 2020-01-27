<?php

declare(strict_types=1);

namespace LevelUpCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127152404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX pruefungs_id ON pruefung_studiPruefung');
        $this->addSql('ALTER TABLE pruefung_studiPruefung ADD pruefungsId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:pruefungsId)\', DROP pruefungs_id, CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:studiPruefungsId)\'');
        $this->addSql('CREATE INDEX pruefungsId ON pruefung_studiPruefung (pruefungsId)');
        $this->addSql('ALTER TABLE pruefung_itemWertung CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:itemWertungsId)\', CHANGE pruefungsItemId pruefungsItemId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:pruefungsItemId)\', CHANGE studiPruefungsId studiPruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:studiPruefungsId)\'');
        $this->addSql('ALTER TABLE pruefung_studiPruefungsWertung CHANGE studiPruefungsId studiPruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:studiPruefungsId)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pruefung_itemWertung CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', CHANGE pruefungsItemId pruefungsItemId VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:aggregateIdString)\', CHANGE studiPruefungsId studiPruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('DROP INDEX pruefungsId ON pruefung_studiPruefung');
        $this->addSql('ALTER TABLE pruefung_studiPruefung ADD pruefungs_id VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP pruefungsId, CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('CREATE INDEX pruefungs_id ON pruefung_studiPruefung (pruefungs_id)');
        $this->addSql('ALTER TABLE pruefung_studiPruefungsWertung CHANGE studiPruefungsId studiPruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
    }
}
