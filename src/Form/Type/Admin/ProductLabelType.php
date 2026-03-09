<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\Form\Type\Admin;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductLabelType extends AbstractResourceType
{
    /** @var string[] */
    protected array $cssClasses;

    public function __construct(
        string $dataClass,
        array $cssClasses = [],
        array $validationGroups = [],
    ) {
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
                'entry_type' => ProductLabelTranslationType::class,
                'label' => 'sylius.form.option.name',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'integritty_sylius_product_label_plugin_product_label';
    }
}
