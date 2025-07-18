<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250718080244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update Service entity name in database to services';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_service DROP CONSTRAINT fk_92887a49ed5ca9e6');
        $this->addSql('ALTER TABLE pack_service DROP CONSTRAINT fk_dad40aafed5ca9e6');
        $this->addSql('DROP SEQUENCE subscription_services_id_seq CASCADE');
        $this->addSql('CREATE TABLE "services" (id SERIAL NOT NULL, type_service_id INT NOT NULL, name VARCHAR(200) NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7332E169F05F7FC3 ON "services" (type_service_id)');
        $this->addSql('COMMENT ON COLUMN "services".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "services" ADD CONSTRAINT FK_7332E169F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_services DROP CONSTRAINT fk_149cbe45f05f7fc3');
        $this->addSql('DROP TABLE subscription_services');
        $this->addSql('ALTER TABLE pack_service DROP CONSTRAINT FK_DAD40AAFED5CA9E6');
        $this->addSql('ALTER TABLE pack_service ADD CONSTRAINT FK_DAD40AAFED5CA9E6 FOREIGN KEY (service_id) REFERENCES "services" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_service DROP CONSTRAINT FK_92887A49ED5CA9E6');
        $this->addSql('ALTER TABLE subscription_service ADD CONSTRAINT FK_92887A49ED5CA9E6 FOREIGN KEY (service_id) REFERENCES "services" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pack_service DROP CONSTRAINT FK_DAD40AAFED5CA9E6');
        $this->addSql('ALTER TABLE subscription_service DROP CONSTRAINT FK_92887A49ED5CA9E6');
        $this->addSql('CREATE SEQUENCE subscription_services_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE subscription_services (id SERIAL NOT NULL, type_service_id INT NOT NULL, name VARCHAR(200) NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_149cbe45f05f7fc3 ON subscription_services (type_service_id)');
        $this->addSql('COMMENT ON COLUMN subscription_services.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_services ADD CONSTRAINT fk_149cbe45f05f7fc3 FOREIGN KEY (type_service_id) REFERENCES type_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "services" DROP CONSTRAINT FK_7332E169F05F7FC3');
        $this->addSql('DROP TABLE "services"');
        $this->addSql('ALTER TABLE subscription_service DROP CONSTRAINT fk_92887a49ed5ca9e6');
        $this->addSql('ALTER TABLE subscription_service ADD CONSTRAINT fk_92887a49ed5ca9e6 FOREIGN KEY (service_id) REFERENCES subscription_services (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pack_service DROP CONSTRAINT fk_dad40aafed5ca9e6');
        $this->addSql('ALTER TABLE pack_service ADD CONSTRAINT fk_dad40aafed5ca9e6 FOREIGN KEY (service_id) REFERENCES subscription_services (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
