<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Form\Extension\Admin;

use Integritty\SyliusProductLabelPlugin\Form\Type\Admin\ProductLabelAutocompleteType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType as ProductFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productLabels', ProductLabelAutocompleteType::class, [
                'label' => 'sylius.form.product.product_labels',
                'multiple' => true,
                'by_reference' => false,
            ]);
    }

    public static function getExtendedTypes(): array
    {
        return [ProductFormType::class];
    }
}
