<?php

declare(strict_types=1);

namespace Integritty\SyliusIntegrittyPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress UnusedVariable
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('integritty_sylius_integritty');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
