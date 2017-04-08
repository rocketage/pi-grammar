<?php

namespace AppBundle\Services\Content;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Topic implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('content');

        $rootNode
            ->children()
                ->scalarNode('topic')->end()

                ->arrayNode('subtopic')
                    ->children()
                        ->scalarNode('name')->end()
                        ->scalarNode('description')->end()
                    ->end()
                ->end()

                ->arrayNode('grammar')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->end()
                            ->arrayNode('usages')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('usage')->end()
                                        ->arrayNode('examples')
                                            ->prototype('scalar')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end();
//            ->arrayNode('topic')
//            ->children()
//            ->scalarNode('name')->end()
//            ->end()
//            ->end()
//
//
//            ->defaultTrue()
//            ->end()
//            ->scalarNode('default_connection')
//            ->defaultValue('default')
//            ->end()
//            ->end()

        // ... add node definitions to the root of the tree

        return $treeBuilder;
    }
}
