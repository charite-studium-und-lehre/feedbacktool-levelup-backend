<?php

declare(strict_types=1);

namespace LevelUpCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191101162203 extends AbstractMigration
{
    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE IF NOT EXISTS epa_fremdBewertung_anfrage (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', loginHash VARCHAR(100) NOT NULL COMMENT \'(DC2Type:loginHash)\', fremdBewertungsAnfrageTaetigkeiten VARCHAR(2000) DEFAULT NULL COMMENT \'(DC2Type:fremdBewertungsAnfrageTaetigkeiten)\', fremdBewertungsAnfrageKommentar VARCHAR(2000) DEFAULT NULL COMMENT \'(DC2Type:fremdBewertungsAnfrageKommentar)\', datum DATE NOT NULL, vollerName VARCHAR(100) NOT NULL, email VARCHAR(60) NOT NULL, anfrageToken VARCHAR(100) NOT NULL, INDEX loginHash (loginHash), INDEX datum (datum), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE epa_fremdBewertung_anfrage');
    }
}
