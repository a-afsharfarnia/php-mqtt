<?php
/**
 * Project_Name: Websocket-MQTT in PHP
 * package_Name: a-afsharfarnia/php-mqtt
 * Created_By: Abbas Afsharfarnia (05/09/2020 10:10)
 * Project_Address: https://github.com/a-afsharfarnia/php-mqtt
 */

namespace SampleBundle\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

class SampleExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter(
            'sample.websocket.mqtt.host',
            $config['emqtt']['host']
        );

        $container->setParameter(
            'sample.websocket.mqtt.port',
            $config['emqtt']['port']
        );

        $container->setParameter(
            'sample.websocket.mqtt.client_id',
            $config['emqtt']['client_id']
        );

        $container->setParameter(
            'sample.websocket.mqtt.username',
            $config['emqtt']['username']
        );

        $container->setParameter(
            'sample.websocket.mqtt.password',
            $config['emqtt']['password']
        );

        $container->setParameter(
            'sample.websocket.mqtt.cafile',
            $config['emqtt']['cafile']
        );
    }
}