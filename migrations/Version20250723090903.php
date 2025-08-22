<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250723090903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add relation for branding project and client';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE branding_project ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE branding_project ADD CONSTRAINT FK_D07FF9A319EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D07FF9A319EB6921 ON branding_project (client_id)');
        $this->addSql('ALTER TABLE design_brief ADD branding_id INT NOT NULL');
        $this->addSql('ALTER TABLE design_brief ADD CONSTRAINT FK_B95A6124560BC00E FOREIGN KEY (branding_id) REFERENCES branding_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B95A6124560BC00E ON design_brief (branding_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE design_brief DROP CONSTRAINT FK_B95A6124560BC00E');
        $this->addSql('DROP INDEX IDX_B95A6124560BC00E');
        $this->addSql('ALTER TABLE design_brief DROP branding_id');
        $this->addSql('ALTER TABLE branding_project DROP CONSTRAINT FK_D07FF9A319EB6921');
        $this->addSql('DROP INDEX IDX_D07FF9A319EB6921');
        $this->addSql('ALTER TABLE branding_project DROP client_id');
    }
}
