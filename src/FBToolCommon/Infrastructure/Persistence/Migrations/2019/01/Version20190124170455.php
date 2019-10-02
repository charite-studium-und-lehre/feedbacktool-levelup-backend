<?php

declare(strict_types=1);

namespace FBToolCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124170455 extends AbstractMigration
{
    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', occurredOn DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', byUserId INT DEFAULT NULL, class VARCHAR(100) NOT NULL, body LONGTEXT NOT NULL, INDEX occurredOn (occurredOn), INDEX byUserId (byUserId), INDEX eventClass (class), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cluster (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', parentId INTEGER DEFAULT NULL COMMENT \'(DC2Type:aggregateId)\', clusterTyp_id INT NOT NULL, clusterTitel VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cluster_zuordnung (clusterId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', wertungsItemId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', PRIMARY KEY(clusterId, wertungsItemId)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
                       'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE cluster');
        $this->addSql('DROP TABLE cluster_zuordnung');
    }
}
