<?php

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Resource\Model\TimestampableTrait;
use Sylius\Resource\Model\TranslatableTrait;

class ProductBadge implements ProductBadgeInterface
{
    use TimestampableTrait;
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }

    /** @var mixed */
    protected $id;

    /** @var string|null */
    protected $cssClass;

    /** @var Collection<int, ProductInterface> */
    protected $products;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->createdAt = new \DateTime();
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(?string $name): void
    {
        $this->getTranslation()->setName($name);
    }

    public function getCssClass(): ?string
    {
        return $this->cssClass;
    }

    public function setCssClass(?string $cssClass): void
    {
        $this->cssClass = $cssClass;
    }

    /**
     * @return ProductBadgeTranslationInterface
     */
    public function getTranslation(?string $locale = null): ProductBadgeTranslationInterface
    {
        /** @var ProductBadgeTranslationInterface $translation */
        $translation = $this->doGetTranslation($locale);

        return $translation;
    }

    protected function createTranslation(): ProductBadgeTranslationInterface
    {
        return new ProductBadgeTranslation();
    }


    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductInterface $product): void
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addProductBadge($this); // maintain bidirectional
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if ($this->products->removeElement($product)) {
            $product->removeProductBadge($this); // maintain bidirectional
        }
    }
}
