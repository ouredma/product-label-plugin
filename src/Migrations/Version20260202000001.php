<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260202000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product label tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE integritty_product_label (id INT AUTO_INCREMENT NOT NULL, css_class VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE integritty_product_label_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_PRODUCT_LABEL_TRANS_TRANSLATABLE (translatable_id), UNIQUE INDEX integritty_product_label_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE integritty_product_label_products (product_label_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_PRODUCT_LABEL_PRODUCTS_LABEL (product_label_id), INDEX IDX_PRODUCT_LABEL_PRODUCTS_PRODUCT (product_id), PRIMARY KEY(product_label_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE integritty_product_label_translation ADD CONSTRAINT FK_PRODUCT_LABEL_TRANS_TRANSLATABLE FOREIGN KEY (translatable_id) REFERENCES integritty_product_label (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE integritty_product_label_products ADD CONSTRAINT FK_PRODUCT_LABEL_PRODUCTS_LABEL FOREIGN KEY (product_label_id) REFERENCES integritty_product_label (id)');
        $this->addSql('ALTER TABLE integritty_product_label_products ADD CONSTRAINT FK_PRODUCT_LABEL_PRODUCTS_PRODUCT FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE integritty_product_label_translation DROP FOREIGN KEY FK_PRODUCT_LABEL_TRANS_TRANSLATABLE');
        $this->addSql('ALTER TABLE integritty_product_label_products DROP FOREIGN KEY FK_PRODUCT_LABEL_PRODUCTS_LABEL');
        $this->addSql('ALTER TABLE integritty_product_label_products DROP FOREIGN KEY FK_PRODUCT_LABEL_PRODUCTS_PRODUCT');
        $this->addSql('DROP TABLE integritty_product_label');
        $this->addSql('DROP TABLE integritty_product_label_translation');
        $this->addSql('DROP TABLE integritty_product_label_products');
    }
}
