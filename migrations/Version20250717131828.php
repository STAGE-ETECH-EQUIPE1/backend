<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717131828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack_service (pack_id INT NOT NULL, service_id INT NOT NULL, PRIMARY KEY(pack_id, service_id))');
        $this->addSql('CREATE INDEX IDX_DAD40AAF1919B217 ON pack_service (pack_id)');
        $this->addSql('CREATE INDEX IDX_DAD40AAFED5CA9E6 ON pack_service (service_id)');
        $this->addSql('ALTER TABLE pack_service ADD CONSTRAINT FK_DAD40AAF1919B217 FOREIGN KEY (pack_id) REFERENCES "service_packs" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pack_service ADD CONSTRAINT FK_DAD40AAFED5CA9E6 FOREIGN KEY (service_id) REFERENCES "subscription_services" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pack_service DROP CONSTRAINT FK_DAD40AAF1919B217');
        $this->addSql('ALTER TABLE pack_service DROP CONSTRAINT FK_DAD40AAFED5CA9E6');
        $this->addSql('DROP TABLE pack_service');
    }
}
