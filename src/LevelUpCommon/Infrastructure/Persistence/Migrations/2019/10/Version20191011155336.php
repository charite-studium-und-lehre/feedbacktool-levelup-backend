<?php

declare(strict_types=1);

namespace LevelUpCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011155336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//        $this->addSql('DROP INDEX studiHash ON epa_selbstBewertung');
        $this->addSql('ALTER TABLE epa_selbstBewertung ADD loginHash VARCHAR(100) NOT NULL COMMENT \'(DC2Type:loginHash)\' AFTER id , DROP studiHash');
        $this->addSql('CREATE INDEX loginHash ON epa_selbstBewertung (loginHash)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX loginHash ON epa_selbstBewertung');
        $this->addSql('ALTER TABLE epa_selbstBewertung ADD studiHash VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:studiHash)\', DROP loginHash');
        $this->addSql('CREATE INDEX studiHash ON epa_selbstBewertung (studiHash)');
    }
}
