## Hot to implement Product Badges in Sylius
## 1. Composer:
```bash
composer require integritty/sylius-product-badge-plugin "@dev"
```

## 2.Basic configuration:
Add plugin dependencies to your `config/bundles.php` file:

```php
# config/bundles.php

return [
    ...
    Integritty\SyliusProductBadgePlugin\IntegrittySyliusProductBadgePlugin::class => ['all' => true],
];
```

## 3.Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
    ...
        - { resource: "@IntegrittySyliusProductBadgePlugin/config/config.yaml" }
```

## 4. In project override Product.php to use the ProductBadgeableTrait and implement ProductBadgeableInterface
```php
// src/Entity/Product/Product.php
namespace App\Entity\Product;
use Integritty\SyliusProductBadgePlugin\Model\ProductBadgeableInterface;
use Integritty\SyliusProductBadgePlugin\Model\ProductBadgeableTrait;
class Product extends BaseProduct implements ProductBadgeableInterface
{
    use ProductBadgeableTrait;
    ...
}
```
## 5. Import routing on top of your `config/routes.yaml` file:
```yaml
# config/routes.yaml
   integritty_sylius_product_badge_plugin:
   resource: "@IntegrittySyliusProductBadgePlugin/config/routes.yaml"
```

## 6. Run migrations
```bash
php bin/console doctrine:migrations:migrate
```
