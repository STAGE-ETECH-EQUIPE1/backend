<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration corrigée : évite la duplication de colonne delete_at.
 */
final class Version20250904085513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la colonne delete_at dans subscriptions (si elle n’existe pas déjà)';
    }

    public function up(Schema $schema): void
    {
        // Ajout de la colonne seulement si elle n'existe pas déjà
        $this->addSql('ALTER TABLE subscriptions ADD COLUMN IF NOT EXISTS delete_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN subscriptions.delete_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // Pour éviter les conflits, on ne supprime que si elle existe
        $this->addSql('ALTER TABLE subscriptions DROP COLUMN IF EXISTS delete_at');
    }
}
