<?php

declare(strict_types=1);

namespace FBToolCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190731131329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cluster_zuordnung CHANGE pruefungsItemId pruefungsItemId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\'');
        $this->addSql('ALTER TABLE pruefung_itemWertung CHANGE studiPruefungsId studiPruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cluster_zuordnung CHANGE pruefungsItemId pruefungsItemId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE pruefung_itemWertung CHANGE studiPruefungsId studiPruefungsId VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:aggregateIdString)\'');
    }
}
