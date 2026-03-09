<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Integritty\SyliusProductLabelPlugin\Entity\ProductLabelInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use SyliusLabs\AssociationHydrator\AssociationHydrator;

/**
 * @template T of ProductLabelInterface
 *
 * @extends EntityRepository<T>
 * @implements ProductLabelRepositoryInterface<T>
 */
class ProductLabelRepository extends EntityRepository implements ProductLabelRepositoryInterface
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
        $labels = parent::findAll();

        $this->associationHydrator->hydrateAssociation($labels, 'translations');

        return $labels;
    }
}
