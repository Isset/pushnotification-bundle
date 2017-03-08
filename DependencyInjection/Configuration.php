<?php

declare(strict_types=1);

namespace IssetBV\PushNotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('isset_bv_push_notification');
        $rootNode->children()->scalarNode('connection_handler')->defaultNull()->end();
        $this->addApple($rootNode);
        $this->addAndroid($rootNode);
        $this->addWindows($rootNode);

        return $treeBuilder;
    }

    private function addApple(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('apple')
            ->children()
            ->scalarNode('connection_handler')->defaultValue(null)->end()
            ->arrayNode('connections')
            ->prototype('array')
            ->children()
            ->scalarNode('url')->defaultValue('ssl://gateway.push.apple.com:2195')->end()
            ->scalarNode('key_location')->cannotBeEmpty()->isRequired()->end()
            ->scalarNode('key_password_phrase')->defaultValue('')->end()
            ->scalarNode('default')->defaultFalse()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addAndroid(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('android')
            ->children()
            ->scalarNode('connection_handler')->defaultValue(null)->end()
            ->arrayNode('connections')
            ->prototype('array')
            ->children()
            ->scalarNode('url')->defaultValue('https://fcm.googleapis.com/fcm/send')->end()
            ->scalarNode('api_key')->cannotBeEmpty()->isRequired()->end()
            ->scalarNode('timeout')->defaultValue(5)->end()
            ->scalarNode('default')->defaultFalse()->end()
            ->scalarNode('dry_run')->defaultFalse()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    private function addWindows(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('windows')
            ->children()
            ->scalarNode('connection_handler')->defaultValue(null)->end()
            ->arrayNode('connections')
            ->prototype('array')
            ->children()
            ->scalarNode('default')->defaultFalse()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }
}
