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
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use SyliusLabs\AssociationHydrator\AssociationHydrator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
/**
 * @template T of ProductBadgeInterface
 *
 * @extends EntityRepository<T>
 * @implements ProductBadgeRepositoryInterface<T>
 */
class ProductBadgeRepository extends EntityRepository implements ProductBadgeRepositoryInterface
{
    protected AssociationHydrator $associationHydrator;

    public function __construct(EntityManagerInterface $entityManager, ClassMetadata $class)
    {
        parent::__construct($entityManager, $class);
    }
    public function createListQueryBuilder(string $locale): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.translations', 'translation')
            ->andWhere('translation.locale = :locale')
            ->setParameter('locale', $locale);
    }

    public function findAll(): array
    {
        $tags = parent::findAll();

        $this->associationHydrator->hydrateAssociation($tags, 'translations');

        return $tags;
    }
}
