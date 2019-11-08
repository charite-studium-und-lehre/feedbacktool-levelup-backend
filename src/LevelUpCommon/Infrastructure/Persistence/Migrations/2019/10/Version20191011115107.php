<?php

declare(strict_types=1);

namespace LevelUpCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011115107 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE __tableAutoIncrement (tableName VARCHAR(200) NOT NULL, autoIncrement INT NOT NULL, INDEX tableName (tableName), PRIMARY KEY(tableName)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE __event (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', occurredOn DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', byUserId INT DEFAULT NULL, class VARCHAR(100) NOT NULL, body LONGTEXT NOT NULL, INDEX occurredOn (occurredOn), INDEX byUserId (byUserId), INDEX eventClass (class), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cluster (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', parentId INTEGER DEFAULT NULL COMMENT \'(DC2Type:aggregateId)\', code VARCHAR(8) DEFAULT NULL COMMENT \'(DC2Type:clusterCode)\', typ INT NOT NULL, clusterTitel VARCHAR(100) NOT NULL, INDEX typ (typ), INDEX parentId (parentId), INDEX code (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cluster_zuordnung (clusterId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', pruefungsItemId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', PRIMARY KEY(clusterId, pruefungsItemId)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE epa_selbstBewertung (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', studiHash VARCHAR(100) NOT NULL COMMENT \'(DC2Type:studiHash)\', typ INT NOT NULL, datum DATE NOT NULL, bewertung INT NOT NULL, epaId INT NOT NULL, INDEX studiHash (studiHash), INDEX datum (datum), INDEX typ (typ), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pruefung (id VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', pruefungsPeriode INTEGER DEFAULT NULL COMMENT \'(DC2Type:pruefungsPeriode)\', format INT NOT NULL, INDEX pruefungsPeriode (pruefungsPeriode), INDEX format (format), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pruefung_item (id VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', pruefungsId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', itemSchwierigkeit INTEGER DEFAULT NULL COMMENT \'(DC2Type:itemSchwierigkeit)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studi_intern (matrikelnummer INTEGER NOT NULL COMMENT \'(DC2Type:matrikelnummer)\', studiHash VARCHAR(100) NOT NULL COMMENT \'(DC2Type:studiHash)\', INDEX studiHash (studiHash), PRIMARY KEY(matrikelnummer)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studi (studiHash VARCHAR(100) NOT NULL COMMENT \'(DC2Type:studiHash)\', loginHash VARCHAR(100) DEFAULT NULL COMMENT \'(DC2Type:loginHash)\', INDEX loginHash (loginHash), PRIMARY KEY(studiHash)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pruefung_studiPruefung (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', studiHash VARCHAR(100) NOT NULL COMMENT \'(DC2Type:studiHash)\', bestanden TINYINT(1) NOT NULL, pruefungs_id VARCHAR(30) NOT NULL, INDEX pruefungs_id (pruefungs_id), INDEX studiHash (studiHash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studi_meilenstein (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', studiHash VARCHAR(100) NOT NULL COMMENT \'(DC2Type:studiHash)\', meilenstein SMALLINT NOT NULL, INDEX studiHash (studiHash), INDEX meilenstein (meilenstein), UNIQUE INDEX Studienfortschritt (studiHash, meilenstein), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pruefung_studiPruefungsWertung (studiPruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', gesamtErgebnis BIGINT SIGNED NOT NULL COMMENT \'(DC2Type:wertung)\', bestehensGrenze BIGINT SIGNED DEFAULT NULL COMMENT \'(DC2Type:wertung)\', PRIMARY KEY(studiPruefungsId)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pruefung_itemWertung (id INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', pruefungsItemId VARCHAR(30) NOT NULL COMMENT \'(DC2Type:aggregateIdString)\', studiPruefungsId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', wertung BIGINT SIGNED NOT NULL COMMENT \'(DC2Type:wertung)\', INDEX pruefungsItemId (pruefungsItemId), INDEX studiPruefungsId (studiPruefungsId), INDEX pruefungsItemIdUndStudiPruefungsId (pruefungsItemId, studiPruefungsId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE importData_lernziel_fach (lernzielNummer INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', clusterId INTEGER NOT NULL COMMENT \'(DC2Type:aggregateId)\', PRIMARY KEY(lernzielNummer, clusterId)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE __tableAutoIncrement');
        $this->addSql('DROP TABLE __event');
        $this->addSql('DROP TABLE cluster');
        $this->addSql('DROP TABLE cluster_zuordnung');
        $this->addSql('DROP TABLE epa_selbstBewertung');
        $this->addSql('DROP TABLE pruefung');
        $this->addSql('DROP TABLE pruefung_item');
        $this->addSql('DROP TABLE studi_intern');
        $this->addSql('DROP TABLE studi');
        $this->addSql('DROP TABLE pruefung_studiPruefung');
        $this->addSql('DROP TABLE studi_meilenstein');
        $this->addSql('DROP TABLE pruefung_studiPruefungsWertung');
        $this->addSql('DROP TABLE pruefung_itemWertung');
        $this->addSql('DROP TABLE importData_lernziel_fach');
    }
}
