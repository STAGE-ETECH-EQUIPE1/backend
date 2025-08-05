<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250730074845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation for branding project and logo version';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logo_version ADD branding_id INT NOT NULL');
        $this->addSql('ALTER TABLE logo_version ADD CONSTRAINT FK_8B3639B3560BC00E FOREIGN KEY (branding_id) REFERENCES branding_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8B3639B3560BC00E ON logo_version (branding_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE logo_version DROP CONSTRAINT FK_8B3639B3560BC00E');
        $this->addSql('DROP INDEX IDX_8B3639B3560BC00E');
        $this->addSql('ALTER TABLE logo_version DROP branding_id');
    }
}
