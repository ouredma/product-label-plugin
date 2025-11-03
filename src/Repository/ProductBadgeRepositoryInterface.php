<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Repository;

use Integritty\SyliusProductBadgePlugin\Entity\ProductBadgeInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @template T of ProductBadgeInterface
 *
 * @extends RepositoryInterface<T>
 */
interface ProductBadgeRepositoryInterface extends RepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder;

}
