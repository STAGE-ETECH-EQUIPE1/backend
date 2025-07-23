<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250723090605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return ' create table backgrounJob, backgroundJobType, brandAiPromptHistory, brandingProject, clientFeedBack, designBrief, logoVersion';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE background_job (id SERIAL NOT NULL, payload JSON NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, finished_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, error TEXT DEFAULT NULL, attempts INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN background_job.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN background_job.started_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN background_job.finished_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE background_job_type (id SERIAL NOT NULL, name VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE brand_ai_prompt_history (id SERIAL NOT NULL, prompt_text TEXT NOT NULL, executed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN brand_ai_prompt_history.executed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE branding_project (id SERIAL NOT NULL, name VARCHAR(200) NOT NULL, status VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, dead_line TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN branding_project.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN branding_project.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN branding_project.dead_line IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE client_feed_back (id SERIAL NOT NULL, client_id INT NOT NULL, logo_version_id INT NOT NULL, comment TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_679FA6F19EB6921 ON client_feed_back (client_id)');
        $this->addSql('CREATE INDEX IDX_679FA6F60679DD1 ON client_feed_back (logo_version_id)');
        $this->addSql('COMMENT ON COLUMN client_feed_back.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE design_brief (id SERIAL NOT NULL, color_preferences JSON DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE logo_version (id SERIAL NOT NULL, asset_url VARCHAR(200) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, approved_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, iteration_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN logo_version.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN logo_version.approved_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE client_feed_back ADD CONSTRAINT FK_679FA6F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_feed_back ADD CONSTRAINT FK_679FA6F60679DD1 FOREIGN KEY (logo_version_id) REFERENCES logo_version (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE client_feed_back DROP CONSTRAINT FK_679FA6F19EB6921');
        $this->addSql('ALTER TABLE client_feed_back DROP CONSTRAINT FK_679FA6F60679DD1');
        $this->addSql('DROP TABLE background_job');
        $this->addSql('DROP TABLE background_job_type');
        $this->addSql('DROP TABLE brand_ai_prompt_history');
        $this->addSql('DROP TABLE branding_project');
        $this->addSql('DROP TABLE client_feed_back');
        $this->addSql('DROP TABLE design_brief');
        $this->addSql('DROP TABLE logo_version');
    }
}
