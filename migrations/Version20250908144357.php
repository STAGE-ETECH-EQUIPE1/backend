<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250908144357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration sécurisée pour client et messenger_messages';
    }

    public function up(Schema $schema): void
    {
        // Supprime la séquence et la table si elles existent
        $this->addSql('DROP SEQUENCE IF EXISTS messenger_messages_id_seq CASCADE');
        $this->addSql('DROP TABLE IF EXISTS messenger_messages');

        // Colonnes du client : n'ajoute que si elles n'existent pas
        $this->addSql('ALTER TABLE client ADD COLUMN IF NOT EXISTS slogan VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD COLUMN IF NOT EXISTS ton_voice VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD COLUMN IF NOT EXISTS qualities JSON DEFAULT NULL');

        // Pour public_target, on doit d'abord remplir les valeurs NULL avant NOT NULL
        $this->addSql('UPDATE client SET public_target = \'default\' WHERE public_target IS NULL');
        $this->addSql('ALTER TABLE client ADD COLUMN IF NOT EXISTS public_target VARCHAR(200)');
        $this->addSql('ALTER TABLE client ALTER COLUMN public_target SET NOT NULL');

        $this->addSql('ALTER TABLE client ADD COLUMN IF NOT EXISTS main_service VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD COLUMN IF NOT EXISTS main_language VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD COLUMN IF NOT EXISTS color_preferences JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD COLUMN IF NOT EXISTS typographie VARCHAR(200) DEFAULT NULL');

        // Supprime la colonne de design_brief si elle existe
        $this->addSql('ALTER TABLE design_brief DROP COLUMN IF EXISTS slogan');
    }

    public function down(Schema $schema): void
    {
        // Recréation séquence et table messenger_messages
        $this->addSql('CREATE SEQUENCE IF NOT EXISTS messenger_messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE IF NOT EXISTS messenger_messages (
            id BIGSERIAL NOT NULL PRIMARY KEY,
            body TEXT NOT NULL,
            headers TEXT NOT NULL,
            queue_name VARCHAR(190) NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL
        )');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_75ea56e016ba31db ON messenger_messages (delivered_at)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_75ea56e0e3bd61ce ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_75ea56e0fb7336f0 ON messenger_messages (queue_name)');

        // Supprime les colonnes du client si elles existent
        $this->addSql('ALTER TABLE client DROP COLUMN IF EXISTS slogan');
        $this->addSql('ALTER TABLE client DROP COLUMN IF EXISTS ton_voice');
        $this->addSql('ALTER TABLE client DROP COLUMN IF EXISTS qualities');
        $this->addSql('ALTER TABLE client DROP COLUMN IF EXISTS public_target');
        $this->addSql('ALTER TABLE client DROP COLUMN IF EXISTS main_service');
        $this->addSql('ALTER TABLE client DROP COLUMN IF EXISTS main_language');
        $this->addSql('ALTER TABLE client DROP COLUMN IF EXISTS color_preferences');
        $this->addSql('ALTER TABLE client DROP COLUMN IF EXISTS typographie');

        $this->addSql('ALTER TABLE design_brief ADD COLUMN IF NOT EXISTS slogan VARCHAR(200) DEFAULT NULL');
    }
}
