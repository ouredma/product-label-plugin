## How to implement Product Badges in Sylius

## 1. Composer:
```bash
composer require integritty/sylius-product-badge-plugin "@dev"
```

## 2. Basic configuration:
Add plugin dependencies to your `config/bundles.php` file:

```php
# config/bundles.php

return [
    ...
    Integritty\SyliusProductBadgePlugin\IntegrittySyliusProductBadgePlugin::class => ['all' => true],
];
```

## 3. Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
    ...
        - { resource: "@IntegrittySyliusProductBadgePlugin/config/config.yaml" }
```

## 4. Configure Doctrine to resolve the ProductInterface:

Add to your `config/packages/doctrine.yaml`:

```yaml
# config/packages/doctrine.yaml

doctrine:
    orm:
        resolve_target_entities:
            Integritty\SyliusProductBadgePlugin\Entity\ProductInterface: App\Entity\Product\Product
```

## 5. Override Product.php to use the ProductBadgeAwareTrait and implement ProductInterface:
```php
// src/Entity/Product/Product.php
namespace App\Entity\Product;

use Integritty\SyliusProductBadgePlugin\Entity\ProductInterface;
use Integritty\SyliusProductBadgePlugin\Entity\ProductBadgeAwareTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct implements ProductInterface
{
    use ProductBadgeAwareTrait;
    ...
}
```

## 6. Import routing on top of your `config/routes.yaml` file:
```yaml
# config/routes.yaml
integritty_sylius_product_badge_plugin:
    resource: "@IntegrittySyliusProductBadgePlugin/config/routes.yaml"
```

## 7. Run migrations
```bash
php bin/console doctrine:migrations:migrate
```
