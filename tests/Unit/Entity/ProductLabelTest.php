<?php

declare(strict_types=1);

namespace Tests\Integritty\SyliusProductLabelPlugin\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabel;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelInterface;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelTranslation;
use PHPUnit\Framework\TestCase;

final class ProductLabelTest extends TestCase
{
    private ProductLabel $productLabel;

    protected function setUp(): void
    {
        $this->productLabel = new ProductLabel();
    }

    public function testItImplementsProductLabelInterface(): void
    {
        $this->assertInstanceOf(ProductLabelInterface::class, $this->productLabel);
    }

    public function testItHasNoIdByDefault(): void
    {
        $this->assertNull($this->productLabel->getId());
    }

    public function testItHasNoCssClassByDefault(): void
    {
        $this->assertNull($this->productLabel->getCssClass());
    }

    public function testItsCssClassIsMutable(): void
    {
        $this->productLabel->setCssClass('bg-success');

        $this->assertSame('bg-success', $this->productLabel->getCssClass());
    }

    public function testItHasCreatedAtSetOnConstruction(): void
    {
        $this->assertInstanceOf(\DateTimeInterface::class, $this->productLabel->getCreatedAt());
    }

    public function testItHasNoUpdatedAtByDefault(): void
    {
        $this->assertNull($this->productLabel->getUpdatedAt());
    }

    public function testItInitializesProductsCollectionOnConstruction(): void
    {
        $this->assertInstanceOf(ArrayCollection::class, $this->productLabel->getProducts());
        $this->assertCount(0, $this->productLabel->getProducts());
    }

    public function testItInitializesTranslationsCollectionOnConstruction(): void
    {
        $this->assertCount(0, $this->productLabel->getTranslations());
    }

    public function testItCreatesTranslationOfCorrectType(): void
    {
        $this->productLabel->setCurrentLocale('en_US');
        $this->productLabel->setFallbackLocale('en_US');
        $this->productLabel->setName('Test Label');

        $translation = $this->productLabel->getTranslation('en_US');

        $this->assertInstanceOf(ProductLabelTranslation::class, $translation);
    }

    public function testNameIsAccessibleThroughTranslation(): void
    {
        $this->productLabel->setCurrentLocale('en_US');
        $this->productLabel->setFallbackLocale('en_US');
        $this->productLabel->setName('Sale');

        $this->assertSame('Sale', $this->productLabel->getName());
    }

    public function testItSupportsMultipleTranslations(): void
    {
        $this->productLabel->setFallbackLocale('en_US');

        // Create de_DE first — before en_US exists, so TranslatableTrait creates a fresh
        // de_DE translation rather than returning the fallback locale's translation.
        $this->productLabel->setCurrentLocale('de_DE');
        $this->productLabel->setName('Angebot');

        $this->productLabel->setCurrentLocale('en_US');
        $this->productLabel->setName('Sale');

        $this->assertSame('Sale', $this->productLabel->getTranslation('en_US')->getName());
        $this->assertSame('Angebot', $this->productLabel->getTranslation('de_DE')->getName());
    }
}
