<?php

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface ProductBadgeAwareInterface
{
    /**
     * @return Collection<int, ProductBadgeInterface>
     */
    public function getProductBadges(): Collection;

    public function addProductBadge(ProductBadgeInterface $badge): void;

    public function removeProductBadge(ProductBadgeInterface $badge): void;
}
