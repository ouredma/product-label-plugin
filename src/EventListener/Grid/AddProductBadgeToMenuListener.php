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

namespace Integritty\SyliusProductBadgePlugin\EventListener\Grid;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AddProductBadgeToMenuListener
{
    public function buildMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $configuration = $menu->getChild('configuration');
        $configuration
            ->addChild('product_badges', ['route' => 'integritty_sylius_product_badge_plugin_admin_product_badge_index', 'extras' => ['routes' => [
                ['route' => 'integritty_sylius_product_badge_plugin_admin_product_badge_update'],
                ['route' => 'integritty_sylius_product_badge_plugin_admin_product_badge_create']
            ]]])
            ->setLabel('sylius.menu.admin.main.configuration.product_badges')
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
            'product_badges',
            'tax_categories',
            'tax_rates',
            'admin_users',
        ]);
    }
}
