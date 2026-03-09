<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Entity;

use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;
use Sylius\MolliePlugin\Entity\ProductInterface as MollieProductInterface;

interface ProductInterface extends BaseProductInterface, ProductLabelAwareInterface, MollieProductInterface
{
}
