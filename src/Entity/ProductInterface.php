<?php

namespace Integritty\SyliusProductBadgePlugin\Entity;

use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;
use Sylius\MolliePlugin\Entity\ProductInterface as MollieProductInterface;

interface ProductInterface extends BaseProductInterface, ProductBadgeAwareInterface, MollieProductInterface
{
}
