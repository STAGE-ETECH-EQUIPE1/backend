<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250901085059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriptions ADD pack_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A011919B217 FOREIGN KEY (pack_id) REFERENCES "service_packs" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4778A011919B217 ON subscriptions (pack_id)');
        $this->addSql("UPDATE subscriptions SET name = 'subscription-' || id WHERE name IS NULL");
        $this->addSql('ALTER TABLE subscriptions ALTER COLUMN name SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "subscriptions" DROP CONSTRAINT FK_4778A011919B217');
        $this->addSql('DROP INDEX IDX_4778A011919B217');
        $this->addSql('ALTER TABLE "subscriptions" DROP pack_id');
        $this->addSql('ALTER TABLE "subscriptions" DROP name');
    }
}
