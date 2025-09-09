<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717131642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subscription_service (subscription_id INT NOT NULL, service_id INT NOT NULL, PRIMARY KEY(subscription_id, service_id))');
        $this->addSql('CREATE INDEX IDX_92887A499A1887DC ON subscription_service (subscription_id)');
        $this->addSql('CREATE INDEX IDX_92887A49ED5CA9E6 ON subscription_service (service_id)');
        $this->addSql('ALTER TABLE subscription_service ADD CONSTRAINT FK_92887A499A1887DC FOREIGN KEY (subscription_id) REFERENCES "subscriptions" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_service ADD CONSTRAINT FK_92887A49ED5CA9E6 FOREIGN KEY (service_id) REFERENCES "subscription_services" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subscription_service DROP CONSTRAINT FK_92887A499A1887DC');
        $this->addSql('ALTER TABLE subscription_service DROP CONSTRAINT FK_92887A49ED5CA9E6');
        $this->addSql('DROP TABLE subscription_service');
    }
}
