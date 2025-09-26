<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250910153645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_tokens (id SERIAL NOT NULL, user_info_id INT NOT NULL, company_name_tokens INT NOT NULL, color_palette_tokens INT NOT NULL, typography_tokens INT NOT NULL, ton_voice_tokens INT NOT NULL, values_tokens INT NOT NULL, slogan_tokens INT NOT NULL, logo_generation_tokens INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF080AB3586DFF2 ON user_tokens (user_info_id)');
        $this->addSql('ALTER TABLE user_tokens ADD CONSTRAINT FK_CF080AB3586DFF2 FOREIGN KEY (user_info_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_tokens DROP CONSTRAINT FK_CF080AB3586DFF2');
        $this->addSql('DROP TABLE user_tokens');
    }
}
