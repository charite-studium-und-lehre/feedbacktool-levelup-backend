<?php

declare(strict_types=1);

namespace FBToolCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190220154910 extends AbstractMigration
{
    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cluster_zuordnung DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cluster_zuordnung CHANGE wertungsitemid pruefungsItemId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE cluster_zuordnung ADD PRIMARY KEY (clusterId, pruefungsItemId)');
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cluster_zuordnung DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE cluster_zuordnung CHANGE pruefungsitemid wertungsItemId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\'');
        $this->addSql('ALTER TABLE cluster_zuordnung ADD PRIMARY KEY (clusterId, wertungsItemId)');
    }
}
