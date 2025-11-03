<?php

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait ProductBadgeAwareTrait
{
    /**
     * @var Collection<int, ProductBadge>
     */
    #[ORM\ManyToMany(targetEntity: ProductBadgeInterface::class, mappedBy: 'products')]
    private Collection $productBadges;

    public function initializeProductBadgesCollection(): void
    {
        $this->productBadges = new ArrayCollection();
    }

    /**
     * @return Collection<int, ProductBadgeInterface>
     */
    public function getProductBadges(): Collection
    {
        return $this->productBadges;
    }

    public function addProductBadge(ProductBadgeInterface $badge): void
    {
        if (!$this->productBadges->contains($badge)) {
            $this->productBadges->add($badge);
            $badge->addProduct($this);
        }
    }

    public function removeProductBadge(ProductBadgeInterface $badge): void
    {
        if ($this->productBadges->removeElement($badge)) {
            $badge->removeProduct($this);
        }
    }
}
