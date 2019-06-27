<?php

declare(strict_types=1);

namespace FBToolCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version30190627163254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pruefung CHANGE id id VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\'');
        $this->addSql('ALTER TABLE pruefung_item CHANGE id id VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', CHANGE pruefungsId pruefungsId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\'');
        $this->addSql('ALTER TABLE pruefung_itemWertung CHANGE pruefungsItemId pruefungsItemId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\'');
        $this->addSql('ALTER TABLE pruefung_studiPruefung CHANGE pruefungs_id pruefungs_id VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pruefung CHANGE id id INTEGER AUTO_INCREMENT NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE pruefung_item CHANGE id id INTEGER AUTO_INCREMENT NOT NULL COMMENT \'(DC2Type:aggregateId)\', CHANGE pruefungsId pruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE pruefung_itemWertung CHANGE pruefungsItemId pruefungsItemId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE pruefung_studiPruefung CHANGE pruefungs_id pruefungs_id VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
