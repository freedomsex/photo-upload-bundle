<?php

namespace FreedomSex\PhotoUploadBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('photo-upload');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->integerNode('quality')->defaultValue(80)->end()
                ->integerNode('width')->defaultValue(600)->end()
                ->integerNode('height')->defaultValue(800)->end()
//                ->variableNode('namer')->end()
            ->end();

        return $treeBuilder;
    }
}
