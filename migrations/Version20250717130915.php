<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717130915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_orders ADD subscription_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_orders ADD pack_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_orders ADD payment_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_orders ADD CONSTRAINT FK_2CD9E5699A1887DC FOREIGN KEY (subscription_id) REFERENCES "subscriptions" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_orders ADD CONSTRAINT FK_2CD9E5691919B217 FOREIGN KEY (pack_id) REFERENCES "service_packs" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_orders ADD CONSTRAINT FK_2CD9E5694C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2CD9E5699A1887DC ON subscription_orders (subscription_id)');
        $this->addSql('CREATE INDEX IDX_2CD9E5691919B217 ON subscription_orders (pack_id)');
        $this->addSql('CREATE INDEX IDX_2CD9E5694C3A3BB ON subscription_orders (payment_id)');
        $this->addSql('ALTER TABLE subscriptions ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD payment_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A0119EB6921 FOREIGN KEY (client_id) REFERENCES "clients" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A014C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4778A0119EB6921 ON subscriptions (client_id)');
        $this->addSql('CREATE INDEX IDX_4778A014C3A3BB ON subscriptions (payment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "subscription_orders" DROP CONSTRAINT FK_2CD9E5699A1887DC');
        $this->addSql('ALTER TABLE "subscription_orders" DROP CONSTRAINT FK_2CD9E5691919B217');
        $this->addSql('ALTER TABLE "subscription_orders" DROP CONSTRAINT FK_2CD9E5694C3A3BB');
        $this->addSql('DROP INDEX IDX_2CD9E5699A1887DC');
        $this->addSql('DROP INDEX IDX_2CD9E5691919B217');
        $this->addSql('DROP INDEX IDX_2CD9E5694C3A3BB');
        $this->addSql('ALTER TABLE "subscription_orders" DROP subscription_id');
        $this->addSql('ALTER TABLE "subscription_orders" DROP pack_id');
        $this->addSql('ALTER TABLE "subscription_orders" DROP payment_id');
        $this->addSql('ALTER TABLE "subscriptions" DROP CONSTRAINT FK_4778A0119EB6921');
        $this->addSql('ALTER TABLE "subscriptions" DROP CONSTRAINT FK_4778A014C3A3BB');
        $this->addSql('DROP INDEX IDX_4778A0119EB6921');
        $this->addSql('DROP INDEX IDX_4778A014C3A3BB');
        $this->addSql('ALTER TABLE "subscriptions" DROP client_id');
        $this->addSql('ALTER TABLE "subscriptions" DROP payment_id');
    }
}
