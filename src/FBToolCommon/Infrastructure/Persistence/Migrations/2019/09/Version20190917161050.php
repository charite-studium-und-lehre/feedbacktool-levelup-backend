<?php

declare(strict_types=1);

namespace FBToolCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190917161050 extends AbstractMigration
{
    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pruefung_studiPruefungsWertung (studiPruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', gesamtErgebnis BIGINT SIGNED NOT NULL COMMENT \'(DC2Type:wertung)\', bestehensGrenze BIGINT SIGNED DEFAULT NULL COMMENT \'(DC2Type:wertung)\', PRIMARY KEY(studiPruefungsId)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pruefung_studiPruefung ADD bestanden TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pruefung_studiPruefungsWertung');
        $this->addSql('ALTER TABLE pruefung_studiPruefung DROP bestanden');
    }
}
