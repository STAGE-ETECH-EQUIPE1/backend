<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250730204300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'relation between logo version and design brief';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE logo_version ADD brief_id INT NOT NULL');
        $this->addSql('ALTER TABLE logo_version ADD CONSTRAINT FK_8B3639B3757FABFF FOREIGN KEY (brief_id) REFERENCES design_brief (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8B3639B3757FABFF ON logo_version (brief_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE logo_version DROP CONSTRAINT FK_8B3639B3757FABFF');
        $this->addSql('DROP INDEX IDX_8B3639B3757FABFF');
        $this->addSql('ALTER TABLE logo_version DROP brief_id');
    }
}
