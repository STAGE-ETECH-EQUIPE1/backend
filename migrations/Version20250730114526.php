<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250730114526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_services DROP CONSTRAINT fk_149cbe45f05f7fc3');
        $this->addSql('DROP SEQUENCE type_service_id_seq CASCADE');
        $this->addSql('DROP TABLE type_service');
        $this->addSql('DROP INDEX idx_149cbe45f05f7fc3');
        $this->addSql('ALTER TABLE subscription_services DROP type_service_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE type_service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE type_service (id SERIAL NOT NULL, name VARCHAR(250) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "subscription_services" ADD type_service_id INT NOT NULL');
        $this->addSql('ALTER TABLE "subscription_services" ADD CONSTRAINT fk_149cbe45f05f7fc3 FOREIGN KEY (type_service_id) REFERENCES type_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_149cbe45f05f7fc3 ON "subscription_services" (type_service_id)');
    }
}
