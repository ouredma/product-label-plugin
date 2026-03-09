<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\SerializedName;

trait ProductLabelAwareTrait
{
    /**
     * @var Collection<int, ProductLabel>
     */
    #[SerializedName('productLabels'), Groups(['sylius:shop:product:show'])]
    #[MaxDepth(1)]
    private Collection $productLabels;

    public function initializeProductLabelsCollection(): void
    {
        $this->productLabels = new ArrayCollection();
    }

    /**
     * @return Collection<int, ProductLabelInterface>
     */
    public function getProductLabels(): Collection
    {
        return $this->productLabels;
    }

    public function addProductLabel(ProductLabelInterface $label): void
    {
        if (!$this->productLabels->contains($label)) {
            $this->productLabels->add($label);
            $label->addProduct($this);
        }
    }

    public function removeProductLabel(ProductLabelInterface $label): void
    {
        if ($this->productLabels->removeElement($label)) {
            $label->removeProduct($this);
        }
    }
}
