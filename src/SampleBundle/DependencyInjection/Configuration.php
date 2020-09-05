<?php
/**
 * Project_Name: Websocket-MQTT in PHP
 * package_Name: a-afsharfarnia/php-mqtt
 * Created_By: Abbas Afsharfarnia (05/09/2020 10:10)
 * Project_Address: https://github.com/a-afsharfarnia/php-mqtt
 */

namespace SampleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sample');

        $rootNode
            ->children()
                ->arrayNode('emqtt')
                    ->children()
                        ->scalarNode('host')->defaultValue("127.0.0.1")->end()
                        ->scalarNode('port')->defaultValue(1883)->end()
                        ->scalarNode('client_id')->end()
                        ->scalarNode('username')->defaultNull()->end()
                        ->scalarNode('password')->defaultNull()->end()
                        ->scalarNode('cafile')->defaultNull()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}