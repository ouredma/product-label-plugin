<?php

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Resource\Model\TimestampableInterface;

interface ProductBadgeInterface extends TimestampableInterface, ResourceInterface, TranslatableInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getCssClass(): ?string;

    public function setCssClass(?string $cssClass): void;

    /**
     * @return TranslationInterface
     */
    public function getTranslation(?string $locale = null): TranslationInterface;


    public function getProducts(): Collection;

    public function addProduct(ProductInterface $product): void;

    public function removeProduct(ProductInterface $product): void;
}
