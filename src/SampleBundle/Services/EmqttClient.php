<?php
/**
 * Project_Name: Websocket-MQTT in PHP
 * package_Name: a-afsharfarnia/php-mqtt
 * Created_By: Abbas Afsharfarnia (05/09/2020 10:10)
 * Project_Address: https://github.com/a-afsharfarnia/php-mqtt
 */

namespace SampleBundle\Services;

use Bluerhinos\phpMQTT;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EmqttClient
{
    /** @var phpMQTT */
    private $mqtt;

    /** @var ParameterBagInterface */
    private $parameterBag;

    /**
     * EmqttClient constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->parameterBag = $container->getParameterBag();
        $this->initialize();
    }

    public function initialize()
    {
        $host = $this->parameterBag->get('sample.websocket.mqtt.host');
        $port = $this->parameterBag->get('sample.websocket.mqtt.port');
        $clientId = uniqid('', true);
        $cafile = $this->parameterBag->get('sample.websocket.mqtt.cafile');

        $this->mqtt = new phpMQTT($host, $port, $clientId, $cafile);
    }

    public function connect($clean = true, $will = null, $username = NULL, $password = NULL)
    {
        $userName = $username ?: $this->parameterBag->get('sample.websocket.mqtt.username');
        $password = $password ?: $this->parameterBag->get('sample.websocket.mqtt.password');

        return $this->mqtt->connect($clean, $will, $userName, $password);
    }

    public function publish($topic, $content, $qos = 0, $retain = false)
    {
        $this->mqtt->publish($topic, $content, $qos, $retain);
    }

    public function close()
    {
        $this->mqtt->disconnect();
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function emqttUserAuth(string $username, string $password): bool
    {
        $publisherUsername = $this->parameterBag->get('sample.websocket.mqtt.username');
        $publisherPassword = $this->parameterBag->get('sample.websocket.mqtt.password');

        return $username === $publisherUsername && $password === $publisherPassword;
    }

    /**
     * @param int    $access
     * @param string $username
     * @param string $topic
     *
     * @return bool
     */
    public function emqttAcl(int $access, string $username, string $topic): bool
    {
        if ($access === 1) {
            return true;
        }

        $publisherUsername = $this->parameterBag->get('sample.websocket.mqtt.username');

        return $username === $publisherUsername;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $ip
     *
     * @return bool
     */
    public function emqttSuperUserAuth(string $username, string $password, string $ip): bool
    {
        $publisherUsername = $this->parameterBag->get('sample.websocket.mqtt.username');

        return $username === $publisherUsername;
    }
}