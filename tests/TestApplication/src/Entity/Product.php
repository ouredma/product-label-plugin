<?php

declare(strict_types=1);

namespace Tests\Integritty\SyliusProductBadgePlugin;

use Doctrine\ORM\Mapping as ORM;
use Integritty\SyliusProductBadgePlugin\Entity\ProductInterface;
use Integritty\SyliusProductBadgePlugin\Entity\ProductBadgeAwareTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;
use Sylius\MolliePlugin\Entity\ProductTrait;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements ProductInterface
{
    use ProductTrait;
    use ProductBadgeAwareTrait;
}
