<?php

namespace Xuad\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     * @throws \RuntimeException
     */
    public function getConfigTreeBuilder() : TreeBuilder
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