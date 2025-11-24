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
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * @template T of ProductBadgeTranslationInterface
 *
 * @implements ProductBadgeTranslationRepositoryInterface<T>
 */
class ProductBadgeTranslationRepository extends EntityRepository implements ProductBadgeTranslationRepositoryInterface
{
}
