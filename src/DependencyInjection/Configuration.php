<?php

namespace Xuad\BlogBundle\DependencyInjection;

use RuntimeException;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     * @throws RuntimeException
     */
    public function getConfigTreeBuilder() : TreeBuilder
    {
        $treeBuilder = new TreeBuilder('xuad_blog');
        $rootNode = $treeBuilder->getRootNode();

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