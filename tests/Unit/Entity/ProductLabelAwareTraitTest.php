<?php

declare(strict_types=1);

namespace Tests\Integritty\SyliusProductLabelPlugin\Unit\Entity;

use Doctrine\Common\Collections\Collection;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelInterface;
use PHPUnit\Framework\TestCase;
use Tests\Integritty\SyliusProductLabelPlugin\Entity\Product;

final class ProductLabelAwareTraitTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        $this->product = new Product();
    }

    public function testInitializesEmptyCollection(): void
    {
        $this->assertInstanceOf(Collection::class, $this->product->getProductLabels());
        $this->assertCount(0, $this->product->getProductLabels());
    }

    public function testAddProductLabelAddsToCollection(): void
    {
        $label = $this->createMock(ProductLabelInterface::class);
        $label->expects($this->once())->method('addProduct')->with($this->identicalTo($this->product));

        $this->product->addProductLabel($label);

        $this->assertCount(1, $this->product->getProductLabels());
        $this->assertTrue($this->product->getProductLabels()->contains($label));
    }

    public function testAddProductLabelIgnoresDuplicates(): void
    {
        $label = $this->createMock(ProductLabelInterface::class);
        $label->expects($this->once())->method('addProduct'); // only called once

        $this->product->addProductLabel($label);
        $this->product->addProductLabel($label);

        $this->assertCount(1, $this->product->getProductLabels());
    }

    public function testRemoveProductLabelRemovesFromCollection(): void
    {
        $label = $this->createMock(ProductLabelInterface::class);
        $label->expects($this->once())->method('addProduct')->with($this->identicalTo($this->product));
        $label->expects($this->once())->method('removeProduct')->with($this->identicalTo($this->product));

        $this->product->addProductLabel($label);
        $this->product->removeProductLabel($label);

        $this->assertCount(0, $this->product->getProductLabels());
        $this->assertFalse($this->product->getProductLabels()->contains($label));
    }

    public function testRemoveProductLabelDoesNothingWhenNotPresent(): void
    {
        $label = $this->createMock(ProductLabelInterface::class);
        $label->expects($this->never())->method('removeProduct');

        $this->product->removeProductLabel($label);

        $this->assertCount(0, $this->product->getProductLabels());
    }

    public function testCanAddMultipleDifferentLabels(): void
    {
        $label1 = $this->createMock(ProductLabelInterface::class);
        $label1->expects($this->once())->method('addProduct');

        $label2 = $this->createMock(ProductLabelInterface::class);
        $label2->expects($this->once())->method('addProduct');

        $this->product->addProductLabel($label1);
        $this->product->addProductLabel($label2);

        $this->assertCount(2, $this->product->getProductLabels());
    }
}
