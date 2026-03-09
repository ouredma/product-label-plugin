<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Repository;

use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelTranslationInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * @template T of ProductLabelTranslationInterface
 *
 * @implements ProductLabelTranslationRepositoryInterface<T>
 */
class ProductLabelTranslationRepository extends EntityRepository implements ProductLabelTranslationRepositoryInterface
{
}
