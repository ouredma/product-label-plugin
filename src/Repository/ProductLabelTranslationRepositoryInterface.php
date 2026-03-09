<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Repository;

use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelTranslationInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

/**
 * @template T of ProductLabelTranslationInterface
 *
 * @extends RepositoryInterface<T>
 */
interface ProductLabelTranslationRepositoryInterface extends RepositoryInterface
{
}
