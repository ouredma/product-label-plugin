<?php

declare(strict_types=1);

namespace Tests\Integritty\SyliusProductLabelPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
