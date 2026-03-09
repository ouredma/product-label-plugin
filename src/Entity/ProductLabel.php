<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Resource\Model\TimestampableTrait;
use Sylius\Resource\Model\TranslatableTrait;
use Symfony\Component\Serializer\Annotation\Groups;

class ProductLabel implements ProductLabelInterface
{
    use TimestampableTrait;
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }

    /** @var mixed */
    protected $id;

    /** @var string|null */
    #[Groups(['sylius:shop:product:show'])]
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

    #[Groups(['sylius:shop:product:show'])]
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
     * @return ProductLabelTranslationInterface
     */
    public function getTranslation(?string $locale = null): ProductLabelTranslationInterface
    {
        /** @var ProductLabelTranslationInterface $translation */
        $translation = $this->doGetTranslation($locale);

        return $translation;
    }

    protected function createTranslation(): ProductLabelTranslationInterface
    {
        return new ProductLabelTranslation();
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductInterface $product): void
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addProductLabel($this);
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if ($this->products->removeElement($product)) {
            $product->removeProductLabel($this);
        }
    }
}
