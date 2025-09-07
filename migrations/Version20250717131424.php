<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717131424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notifications ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D37E3C61F9 FOREIGN KEY (owner_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6000B0D37E3C61F9 ON notifications (owner_id)');
        $this->addSql('ALTER TABLE subscription_services ADD type_service_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_services ADD CONSTRAINT FK_149CBE45F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_149CBE45F05F7FC3 ON subscription_services (type_service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "notifications" DROP CONSTRAINT FK_6000B0D37E3C61F9');
        $this->addSql('DROP INDEX IDX_6000B0D37E3C61F9');
        $this->addSql('ALTER TABLE "notifications" DROP owner_id');
        $this->addSql('ALTER TABLE "subscription_services" DROP CONSTRAINT FK_149CBE45F05F7FC3');
        $this->addSql('DROP INDEX IDX_149CBE45F05F7FC3');
        $this->addSql('ALTER TABLE "subscription_services" DROP type_service_id');
    }
}
