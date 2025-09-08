<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250902074154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT fk_6d28840d5aa1164f');
        $this->addSql('DROP SEQUENCE payment_method_id_seq CASCADE');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP INDEX idx_6d28840d5aa1164f');
        $this->addSql('ALTER TABLE payment ADD card_number VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD card_type VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD bill_email VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD transaction_id VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD currency VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD decision VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD customer_ip_address VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD bill_to_company_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD transaction_type VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD payment_method VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD reference_number VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE payment ADD message TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment DROP payment_method_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE payment_method_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE payment_method (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, ref VARCHAR(150) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE payment ADD payment_method_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment DROP card_number');
        $this->addSql('ALTER TABLE payment DROP card_type');
        $this->addSql('ALTER TABLE payment DROP bill_email');
        $this->addSql('ALTER TABLE payment DROP transaction_id');
        $this->addSql('ALTER TABLE payment DROP currency');
        $this->addSql('ALTER TABLE payment DROP decision');
        $this->addSql('ALTER TABLE payment DROP customer_ip_address');
        $this->addSql('ALTER TABLE payment DROP bill_to_company_name');
        $this->addSql('ALTER TABLE payment DROP transaction_type');
        $this->addSql('ALTER TABLE payment DROP payment_method');
        $this->addSql('ALTER TABLE payment DROP reference_number');
        $this->addSql('ALTER TABLE payment DROP message');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT fk_6d28840d5aa1164f FOREIGN KEY (payment_method_id) REFERENCES payment_method (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6d28840d5aa1164f ON payment (payment_method_id)');
    }
}
