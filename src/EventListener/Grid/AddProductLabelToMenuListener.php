<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\EventListener\Grid;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AddProductLabelToMenuListener
{
    public function buildMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $configuration = $menu->getChild('configuration');
        if (null === $configuration) {
            return;
        }
        $configuration
            ->addChild('product_labels', [
                'route' => 'integritty_sylius_product_label_plugin_admin_product_label_index',
                'extras' => [
                    'routes' => [
                        ['route' => 'integritty_sylius_product_label_plugin_admin_product_label_update'],
                        ['route' => 'integritty_sylius_product_label_plugin_admin_product_label_create'],
                    ],
                ],
            ])
            ->setLabel('sylius.menu.admin.main.configuration.product_labels')
        ;
        $configuration->reorderChildren([
            'channels',
            'countries',
            'zones',
            'currencies',
            'exchange_rates',
            'locales',
            'payment_methods',
            'shipping_methods',
            'shipping_categories',
            'product_labels',
            'tax_categories',
            'tax_rates',
            'admin_users',
        ]);
    }
}
