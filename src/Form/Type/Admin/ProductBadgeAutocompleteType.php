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

namespace Integritty\SyliusProductBadgePlugin\Form\Type\Admin;

use Sylius\Bundle\AdminBundle\Form\Type\TranslatableAutocompleteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;

#[AsEntityAutocompleteField(
    alias: 'sylius_admin_product_badge',
    route: 'sylius_admin_entity_autocomplete',
)]
final class ProductBadgeAutocompleteType extends AbstractType
{
    public function __construct(
        private readonly string $productBadgeClass,
    ) {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => $this->productBadgeClass,
            'choice_label' => 'name',
            'choice_value' => 'id',
            'entity_fields' => ['cssClass'],
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_admin_product_badge_autocomplete';
    }

    public function getParent(): string
    {
        return TranslatableAutocompleteType::class;
    }
}
