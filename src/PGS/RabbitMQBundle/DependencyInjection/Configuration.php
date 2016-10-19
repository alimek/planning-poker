<?php

namespace PGS\RabbitMQBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('pgs_rabbit_mq')
            ->children()
                    ->scalarNode('host')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
                    ->scalarNode('vhost')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
                    ->scalarNode('user')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
                    ->scalarNode('password')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
