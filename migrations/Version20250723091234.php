<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250723091234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add relation for backgroundJob and backgroundJobType, and brandAiPromptHistory and brandingProject';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE background_job ADD job_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE background_job ADD CONSTRAINT FK_D01ABE645FA33B08 FOREIGN KEY (job_type_id) REFERENCES background_job_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D01ABE645FA33B08 ON background_job (job_type_id)');
        $this->addSql('ALTER TABLE brand_ai_prompt_history ADD branding_id INT NOT NULL');
        $this->addSql('ALTER TABLE brand_ai_prompt_history ADD CONSTRAINT FK_212AACAA560BC00E FOREIGN KEY (branding_id) REFERENCES branding_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_212AACAA560BC00E ON brand_ai_prompt_history (branding_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE brand_ai_prompt_history DROP CONSTRAINT FK_212AACAA560BC00E');
        $this->addSql('DROP INDEX IDX_212AACAA560BC00E');
        $this->addSql('ALTER TABLE brand_ai_prompt_history DROP branding_id');
        $this->addSql('ALTER TABLE background_job DROP CONSTRAINT FK_D01ABE645FA33B08');
        $this->addSql('DROP INDEX IDX_D01ABE645FA33B08');
        $this->addSql('ALTER TABLE background_job DROP job_type_id');
    }
}
