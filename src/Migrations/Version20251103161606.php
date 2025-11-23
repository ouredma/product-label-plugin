<?php

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251103161606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE integritty_dev_sylius_product_badge (id INT AUTO_INCREMENT NOT NULL, css_class VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE integritty_dev_sylius_product_badge_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_273862742C2AC5D3 (translatable_id), UNIQUE INDEX integritty_dev_sylius_product_badge_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE integritty_dev_sylius_product_badge_translation ADD CONSTRAINT FK_273862742C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES integritty_dev_sylius_product_badge (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE integritty_dev_sylius_product_badge_translation DROP FOREIGN KEY FK_273862742C2AC5D3');
        $this->addSql('DROP TABLE integritty_dev_sylius_product_badge');
        $this->addSql('DROP TABLE integritty_dev_sylius_product_badge_translation');
    }
}
