<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250808125624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_services ADD token INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A0119EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4778A0119EB6921 ON subscriptions (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "subscriptions" DROP CONSTRAINT FK_4778A0119EB6921');
        $this->addSql('DROP INDEX IDX_4778A0119EB6921');
        $this->addSql('ALTER TABLE "subscriptions" DROP client_id');
        $this->addSql('ALTER TABLE "subscription_services" DROP token');
    }
}
