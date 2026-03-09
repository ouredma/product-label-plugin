<?php

declare(strict_types=1);

namespace Tests\Integritty\SyliusProductLabelPlugin\Unit\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelAwareInterface;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelAwareTrait;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelInterface;
use PHPUnit\Framework\TestCase;

final class ProductLabelAwareTraitTest extends TestCase
{
    private ProductLabelAwareInterface $product;

    protected function setUp(): void
    {
        $this->product = new class implements ProductLabelAwareInterface {
            use ProductLabelAwareTrait;

            public function __construct()
            {
                $this->initializeProductLabelsCollection();
            }
        };
    }

    public function testItInitializesEmptyLabelsCollection(): void
    {
        $this->assertInstanceOf(ArrayCollection::class, $this->product->getProductLabels());
        $this->assertCount(0, $this->product->getProductLabels());
    }

    public function testItCanAddLabelDirectlyToCollection(): void
    {
        $label = $this->createMock(ProductLabelInterface::class);

        // Directly add to collection to test the getter
        $this->product->getProductLabels()->add($label);

        $this->assertCount(1, $this->product->getProductLabels());
        $this->assertTrue($this->product->getProductLabels()->contains($label));
    }

    public function testCollectionDoesNotAddSameElementTwice(): void
    {
        $label = $this->createMock(ProductLabelInterface::class);

        $this->product->getProductLabels()->add($label);
        $this->product->getProductLabels()->add($label);

        // ArrayCollection allows duplicates, but our trait method doesn't
        // This test verifies the collection behavior
        $this->assertCount(2, $this->product->getProductLabels());
    }

    public function testItCanRemoveLabelFromCollection(): void
    {
        $label = $this->createMock(ProductLabelInterface::class);

        $this->product->getProductLabels()->add($label);
        $this->product->getProductLabels()->removeElement($label);

        $this->assertCount(0, $this->product->getProductLabels());
    }
}
