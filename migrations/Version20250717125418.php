<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717125418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment ADD payment_method_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6D28840D5AA1164F ON payment (payment_method_id)');
        $this->addSql('ALTER TABLE refund ADD payment_id INT NOT NULL');
        $this->addSql('ALTER TABLE refund ADD CONSTRAINT FK_5B2C14584C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5B2C14584C3A3BB ON refund (payment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D5AA1164F');
        $this->addSql('DROP INDEX IDX_6D28840D5AA1164F');
        $this->addSql('ALTER TABLE payment DROP payment_method_id');
        $this->addSql('ALTER TABLE refund DROP CONSTRAINT FK_5B2C14584C3A3BB');
        $this->addSql('DROP INDEX IDX_5B2C14584C3A3BB');
        $this->addSql('ALTER TABLE refund DROP payment_id');
    }
}
