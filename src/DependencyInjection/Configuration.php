<?php

namespace Xuad\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Xuad\BlogBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('xuad_blog');

        $rootNode
            ->children()
            ->booleanNode('enabled')
                ->defaultFalse()
            ->end()
            ->scalarNode('news_archive_category_parameter_name')
                ->cannotBeEmpty()
            ->end()
        ->end();

        return $treeBuilder;
    }
}