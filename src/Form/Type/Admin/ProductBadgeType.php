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

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductBadgeType extends AbstractResourceType
{
    /** @var string[] */
    protected array $cssClasses;

    public function __construct(
        string $dataClass,
        array $cssClasses = [],
        array $validationGroups = [],
    )
    {
        parent::__construct($dataClass, $validationGroups);
        $this->cssClasses = array_combine($cssClasses, $cssClasses);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cssClass', ChoiceType::class, [
                'required' => true,
                'label' => 'sylius.ui.cssClass',
                'choices' => $this->cssClasses,
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => ProductBadgeTranslationType::class,
                'label' => 'sylius.form.option.name',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'yac_dev_sylius_product_badge_plugin_product_badge';
    }
}
