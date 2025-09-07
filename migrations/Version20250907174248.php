<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250907174248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD slogan VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD ton_voice VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD qualities JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD public_target VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE design_brief DROP slogan');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE design_brief ADD slogan VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE client DROP slogan');
        $this->addSql('ALTER TABLE client DROP ton_voice');
        $this->addSql('ALTER TABLE client DROP qualities');
        $this->addSql('ALTER TABLE client DROP public_target');
    }
}
