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

use Integritty\SyliusProductBadgePlugin\Entity\ProductBadgeTranslationInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

/**
 * @template T of ProductBadgeTranslationInterface
 *
 * @extends RepositoryInterface<T>
 */
interface ProductBadgeTranslationRepositoryInterface extends RepositoryInterface
{
}
