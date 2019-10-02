<?php

declare(strict_types=1);

namespace FBToolCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190906152225 extends AbstractMigration
{
    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX pruefungsItemId ON pruefung_itemWertung (pruefungsItemId)');
        $this->addSql('CREATE INDEX studiPruefungsId ON pruefung_itemWertung (studiPruefungsId)');
        $this->addSql('CREATE INDEX pruefungsItemIdUndStudiPruefungsId ON pruefung_itemWertung (pruefungsItemId, studiPruefungsId)');
        $this->addSql('CREATE INDEX typ ON cluster (typ)');
        $this->addSql('CREATE INDEX parentId ON cluster (parentId)');
        $this->addSql('CREATE INDEX code ON cluster (code)');
        $this->addSql('CREATE INDEX studiHash ON studi_intern (studiHash)');
        $this->addSql('CREATE INDEX loginHash ON studi (loginHash)');
        $this->addSql('CREATE INDEX studiHash ON studi_meilenstein (studiHash)');
        $this->addSql('CREATE INDEX meilenstein ON studi_meilenstein (meilenstein)');
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX typ ON cluster');
        $this->addSql('DROP INDEX parentId ON cluster');
        $this->addSql('DROP INDEX code ON cluster');
        $this->addSql('DROP INDEX loginHash ON studi');
        $this->addSql('DROP INDEX studiHash ON studi_intern');
        $this->addSql('DROP INDEX studiHash ON studi_meilenstein');
        $this->addSql('DROP INDEX meilenstein ON studi_meilenstein');
        $this->addSql('DROP INDEX pruefungsItemId ON pruefung_itemWertung');
        $this->addSql('DROP INDEX studiPruefungsId ON pruefung_itemWertung');
        $this->addSql('DROP INDEX pruefungsItemIdUndStudiPruefungsId ON pruefung_itemWertung');
    }
}
