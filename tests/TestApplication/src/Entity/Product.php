<?php

declare(strict_types=1);

namespace Tests\Integritty\SyliusProductBadgePlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Integritty\SyliusProductBadgePlugin\Entity\ProductInterface;
use Integritty\SyliusProductBadgePlugin\Entity\ProductBadgeAwareTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\MolliePlugin\Entity\ProductTrait;

class Product extends BaseProduct implements ProductInterface
{
    use ProductTrait;
    use ProductBadgeAwareTrait;

    public function __construct()
    {
        parent::__construct();
        $this->initializeProductBadgesCollection();
    }
}
