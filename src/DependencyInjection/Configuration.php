<?php

declare(strict_types=1);

namespace Integritty\SyliusProductLabelPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('integritty_sylius_product_label');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->arrayNode('css_classes')
                    ->prototype('scalar')->end()
                    ->defaultValue([])
                    ->info('List of CSS classes available for product labels')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
