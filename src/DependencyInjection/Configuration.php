<?php

declare(strict_types=1);

namespace Integritty\SyliusProductBadgePlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress UnusedVariable
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('integritty_sylius_product_badge');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
            ->arrayNode('css_classes')
            ->prototype('scalar')->end()
            ->defaultValue([]) // Defaults to empty array if not provided
            ->info('List of CSS classes available for product badges')
            ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
