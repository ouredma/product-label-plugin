## How to implement Product Labels in Sylius

## 1. Composer:
```bash
composer require integritty/sylius-product-label-plugin
```

## 2. Basic configuration:
Add plugin dependencies to your `config/bundles.php` file:

```php
# config/bundles.php

return [
    ...
    Integritty\SyliusProductLabelPlugin\IntegrittySyliusProductLabelPlugin::class => ['all' => true],
];
```

## 3. Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
    ...
    - { resource: "@IntegrittySyliusProductLabelPlugin/config/config.yaml" }
```

## 4. Configure Doctrine to resolve the ProductInterface:

Add to your `config/packages/doctrine.yaml`:

```yaml
# config/packages/doctrine.yaml

doctrine:
    orm:
        resolve_target_entities:
            Integritty\SyliusProductLabelPlugin\Entity\ProductInterface: App\Entity\Product\Product
```

## 5. Override Product.php to use the ProductLabelAwareTrait and implement ProductInterface:
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

## 6. Import routing on top of your `config/routes.yaml` file:
```yaml
# config/routes.yaml
integritty_sylius_product_label_plugin:
    resource: "@IntegrittySyliusProductLabelPlugin/config/routes.yaml"
```

## 7. Run migrations
```bash
php bin/console doctrine:migrations:migrate
```
