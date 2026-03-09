<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/** @implements ProductLabelRepositoryInterface<ProductLabelInterface> */
class ProductLabelRepository extends EntityRepository implements ProductLabelRepositoryInterface
{
    public function createListQueryBuilder(string $locale): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.translations', 'translation')
            ->andWhere('translation.locale = :locale')
            ->setParameter('locale', $locale);
    }
}
