<?php

declare(strict_types=1);

namespace Tests\Integritty\SyliusProductLabelPlugin\Unit\Entity;

use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelTranslation;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelTranslationInterface;
use PHPUnit\Framework\TestCase;

final class ProductLabelTranslationTest extends TestCase
{
    private ProductLabelTranslation $translation;

    protected function setUp(): void
    {
        $this->translation = new ProductLabelTranslation();
    }

    public function testItImplementsProductLabelTranslationInterface(): void
    {
        $this->assertInstanceOf(ProductLabelTranslationInterface::class, $this->translation);
    }

    public function testItHasNoIdByDefault(): void
    {
        $this->assertNull($this->translation->getId());
    }

    public function testItHasNoNameByDefault(): void
    {
        $this->assertNull($this->translation->getName());
    }

    public function testItsNameIsMutable(): void
    {
        $this->translation->setName('New Arrival');

        $this->assertSame('New Arrival', $this->translation->getName());
    }

    public function testNameCanBeSetToNull(): void
    {
        $this->translation->setName('Test');
        $this->translation->setName(null);

        $this->assertNull($this->translation->getName());
    }
}
