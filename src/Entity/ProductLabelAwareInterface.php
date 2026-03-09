<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface ProductLabelAwareInterface
{
    /**
     * @return Collection<int, ProductLabelInterface>
     */
    public function getProductLabels(): Collection;

    public function addProductLabel(ProductLabelInterface $label): void;

    public function removeProductLabel(ProductLabelInterface $label): void;
}
