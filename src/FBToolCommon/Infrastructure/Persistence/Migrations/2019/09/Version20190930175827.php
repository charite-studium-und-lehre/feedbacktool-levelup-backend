<?php

declare(strict_types=1);

namespace FBToolCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190930175827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE pruefung ADD pruefungsPeriode INTEGER DEFAULT NULL COMMENT \'(DC2Type:pruefungsPeriode)\', DROP datum');
        $this->addSql('CREATE INDEX pruefungsPeriode ON pruefung (pruefungsPeriode)');
        $this->addSql('CREATE INDEX format ON pruefung (format)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX pruefungsPeriode ON pruefung');
        $this->addSql('DROP INDEX format ON pruefung');
        $this->addSql('ALTER TABLE pruefung ADD datum DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', DROP pruefungsPeriode');
    }
}
