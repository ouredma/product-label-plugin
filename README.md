<p align="center">
  <a href="https://www.integritty.cz">
    <img src="https://cdn.prod.website-files.com/68090cf8dfb1e20fef064d3a/68383bc6ac29fe4ced779ee6_navbar2_logo-light.svg" alt="Integritty" width="220" />
  </a>
</p>

<h1 align="center">Integritty Sylius Product Label Plugin</h1>

<p align="center">
  <a href="https://gitlab.integritty.cz/sylius/product-label-plugin/-/releases"><img src="https://gitlab.integritty.cz/sylius/product-label-plugin/-/badges/release.svg" alt="Latest Release" /></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue" alt="License" /></a>
  <a href="https://gitlab.integritty.cz/sylius/product-label-plugin/-/pipelines"><img src="https://gitlab.integritty.cz/sylius/product-label-plugin/badges/master/pipeline.svg" alt="Build Status" /></a>
</p>

A Sylius plugin that adds product label management to your store. Administrators can create translatable labels — each with a name and a CSS class — and assign them to products. Labels are exposed via the REST API and can be rendered in both the admin panel and the storefront using your own CSS.

## Requirements

- PHP 8.2+
- Sylius 2.0+

## Installation

Install via Composer:

```bash
composer require integritty/sylius-product-label-plugin
```

### 1. Register the bundle

Add the plugin to `config/bundles.php`:

```php
return [
    // ...
    Integritty\SyliusProductLabelPlugin\IntegrittySyliusProductLabelPlugin::class => ['all' => true],
];
```

### 2. Import plugin configuration

Add to `config/packages/_sylius.yaml`:

```yaml
imports:
    # ...
    - { resource: "@IntegrittySyliusProductLabelPlugin/config/config.yaml" }
```

### 3. Configure Doctrine to resolve ProductInterface

Add to `config/packages/doctrine.yaml`:

```yaml
doctrine:
    orm:
        resolve_target_entities:
            Integritty\SyliusProductLabelPlugin\Entity\ProductInterface: App\Entity\Product\Product
```

### 4. Extend your Product entity

Implement the plugin's `ProductInterface` and add the `ProductLabelAwareTrait` to your product entity:

```php
// src/Entity/Product/Product.php
namespace App\Entity\Product;

use Integritty\SyliusProductLabelPlugin\Entity\ProductInterface;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelAwareTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    use ProductLabelAwareTrait;

    public function __construct()
    {
        parent::__construct();
        $this->initializeProductLabelsCollection();
    }
}
```

### 5. Import routing

Add to `config/routes.yaml`:

```yaml
integritty_sylius_product_label_plugin:
    resource: "@IntegrittySyliusProductLabelPlugin/config/routes.yaml"
```

### 6. Run database migrations

```bash
php bin/console doctrine:migrations:migrate
```

## Configuration

No additional configuration is required. The plugin ships with sensible defaults for the admin grid, form types, and API serialisation groups.

To render labels in the storefront, iterate over `product.productLabels` in your Twig templates and apply the CSS class:

```twig
{% for label in product.productLabels %}
    <span class="{{ label.cssClass }}">{{ label.name }}</span>
{% endfor %}
```

## How It Works

- **Labels** are standalone translatable entities (`ProductLabel`) with a `name` (per locale) and a `cssClass` string.
- **Assignment** uses a many-to-many relationship between `ProductLabel` and your `Product` entity, managed via `ProductLabelAwareTrait`.
- **Admin UI** provides a full CRUD grid for labels and a dropdown field on the product edit form, both powered by Sylius Resource Bundle.
- **API** exposes labels on the product response under the `sylius:shop:product:show` serialisation group.

## Development

### Docker (recommended)

```bash
make init       # First-time setup: build, install deps, start containers
make phpunit    # Run unit tests
make behat      # Run feature tests
make phpstan    # Static analysis
make ecs        # Coding standards
```

### Testing

```bash
vendor/bin/phpunit
vendor/bin/behat --strict --tags="~@javascript&&~@mink:chromedriver"
```

## License

This project is released under the [MIT License](LICENSE).
