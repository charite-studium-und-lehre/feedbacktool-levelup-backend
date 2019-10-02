<?php

declare(strict_types=1);

namespace FBToolCommon\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190523160057 extends AbstractMigration
{
    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void {
        $this->addSql("ALTER TABLE `pruefung_studiPruefung` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '(DC2Type:aggregateId)'");
        $this->addSql("ALTER TABLE `pruefung_item` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '(DC2Type:aggregateId)'");
        $this->addSql("ALTER TABLE `pruefung_item` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '(DC2Type:aggregateId)'");

        $this->addSql("ALTER TABLE `cluster` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '(DC2Type:aggregateId)'");

    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
