<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Form\Type\Admin;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductLabelTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.form.option.name',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'integritty_sylius_product_label_plugin_product_label_translation';
    }
}
