<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250718130941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriptions DROP CONSTRAINT fk_4778a0119eb6921');
        $this->addSql('CREATE TABLE client (id SERIAL NOT NULL, user_info_id INT NOT NULL, company_name VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455586DFF2 ON client (user_info_id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455586DFF2 FOREIGN KEY (user_info_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE clients DROP CONSTRAINT fk_c82e74bf396750');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP INDEX idx_4778a0119eb6921');
        $this->addSql('ALTER TABLE subscriptions DROP client_id');
        $this->addSql('ALTER TABLE users DROP type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE clients (id INT NOT NULL, company_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT fk_c82e74bf396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C7440455586DFF2');
        $this->addSql('DROP TABLE client');
        $this->addSql('ALTER TABLE "users" ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "subscriptions" ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE "subscriptions" ADD CONSTRAINT fk_4778a0119eb6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4778a0119eb6921 ON "subscriptions" (client_id)');
    }
}
