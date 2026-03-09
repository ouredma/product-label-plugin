<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Form\Type\Admin;

use Sylius\Bundle\AdminBundle\Form\Type\TranslatableAutocompleteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;

#[AsEntityAutocompleteField(
    alias: 'sylius_admin_product_label',
    route: 'sylius_admin_entity_autocomplete',
)]
final class ProductLabelAutocompleteType extends AbstractType
{
    public function __construct(
        private readonly string $productLabelClass,
    ) {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => $this->productLabelClass,
            'choice_label' => 'name',
            'choice_value' => 'id',
            'entity_fields' => ['cssClass'],
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_admin_product_label_autocomplete';
    }

    public function getParent(): string
    {
        return TranslatableAutocompleteType::class;
    }
}
