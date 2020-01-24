<?php

declare(strict_types=1);

namespace LevelUpCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200124192154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cluster CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:clusterId)\', CHANGE parentId parentId INTEGER DEFAULT NULL COMMENT \'(DC2Type:clusterId)\'');
        $this->addSql('ALTER TABLE cluster_zuordnung CHANGE clusterId clusterId INTEGER NOT NULL COMMENT \'(DC2Type:clusterId)\', CHANGE pruefungsItemId pruefungsItemId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:pruefungsItemId)\'');
        $this->addSql('ALTER TABLE epa_selbstBewertung CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:selbstBewertungsId)\'');
        $this->addSql('ALTER TABLE epa_fremdBewertung CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:fremdBewertungsId)\'');
        $this->addSql('ALTER TABLE epa_fremdBewertung_anfrage CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:fremdBewertungsAnfrageId)\'');
        $this->addSql('ALTER TABLE pruefung_item CHANGE id id VARCHAR(30) NOT NULL COMMENT \'(DC2Type:pruefungsItemId)\'');
        $this->addSql('ALTER TABLE importData_lernziel_fach CHANGE clusterId clusterId INTEGER NOT NULL COMMENT \'(DC2Type:clusterId)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cluster CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', CHANGE parentId parentId INTEGER DEFAULT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE cluster_zuordnung CHANGE clusterId clusterId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', CHANGE pruefungsItemId pruefungsItemId VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:aggregateIdString)\'');
        $this->addSql('ALTER TABLE epa_fremdBewertung CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE epa_fremdBewertung_anfrage CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE epa_selbstBewertung CHANGE id id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE importData_lernziel_fach CHANGE clusterId clusterId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE pruefung_item CHANGE id id VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:aggregateIdString)\'');
    }
}
