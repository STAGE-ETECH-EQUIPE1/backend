<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250730105511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove branding project name and add company area property in entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE branding_project DROP name');
        $this->addSql('ALTER TABLE client ADD company_area VARCHAR(200) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE branding_project ADD name VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE client DROP company_area');
    }
}
