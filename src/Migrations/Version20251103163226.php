<?php

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251103163226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE integritty_product_badge_products (product_badge_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_597C783B3C12A86B (product_badge_id), INDEX IDX_597C783B4584665A (product_id), PRIMARY KEY(product_badge_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE integritty_product_badge_products ADD CONSTRAINT FK_597C783B3C12A86B FOREIGN KEY (product_badge_id) REFERENCES integritty_dev_sylius_product_badge (id)');
        $this->addSql('ALTER TABLE integritty_product_badge_products ADD CONSTRAINT FK_597C783B4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE integritty_product_badge_products DROP FOREIGN KEY FK_597C783B3C12A86B');
        $this->addSql('ALTER TABLE integritty_product_badge_products DROP FOREIGN KEY FK_597C783B4584665A');
        $this->addSql('DROP TABLE integritty_product_badge_products');
    }
}
