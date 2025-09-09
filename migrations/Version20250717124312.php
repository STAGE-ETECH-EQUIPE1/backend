<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717124312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create Payment, PaymentMethod, and Refund entities with their respective migrations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id SERIAL NOT NULL, price NUMERIC(10, 2) NOT NULL, tax DOUBLE PRECISION DEFAULT NULL, is_refunded BOOLEAN DEFAULT NULL, full_name VARCHAR(255) NOT NULL, address VARCHAR(200) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, postal_code VARCHAR(50) DEFAULT NULL, country_code VARCHAR(50) DEFAULT NULL, fee NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE payment_method (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, ref VARCHAR(150) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE refund (id SERIAL NOT NULL, amount NUMERIC(10, 2) NOT NULL, reason TEXT NOT NULL, processed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN refund.processed_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE refund');
    }
}
