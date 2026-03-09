<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

/**
 * @template T of ProductLabelInterface
 *
 * @extends RepositoryInterface<T>
 */
interface ProductLabelRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder;
}
