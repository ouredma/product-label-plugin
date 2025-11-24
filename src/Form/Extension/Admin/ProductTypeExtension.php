<?php

/*
 * This file is part of the Sylius Mollie Plugin package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\Form\Extension\Admin;

use Sylius\Bundle\ProductBundle\Form\Type\ProductType as ProductFormType;
use Integritty\SyliusProductBadgePlugin\Form\Type\Admin\ProductBadgeAutocompleteType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('productBadges', ProductBadgeAutocompleteType::class, [
            'label' => 'sylius.form.product.product_badges',
            'multiple' => true,
            'by_reference' => false,
        ]);
    }

    public static function getExtendedTypes(): array
    {
        return [ProductFormType::class];
    }
}
