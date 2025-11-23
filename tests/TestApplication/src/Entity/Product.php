<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Integritty\SyliusProductBadgePlugin\Entity\ProductBadgeAwareInterface;
use Integritty\SyliusProductBadgePlugin\Entity\ProductBadgeAwareTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;
use Sylius\MolliePlugin\Entity\ProductTrait;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements ProductBadgeAwareInterface
{
    use ProductTrait;
    use ProductBadgeAwareTrait;

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }
}
