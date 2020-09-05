<?php
/**
 * Project_Name: Websocket-MQTT in PHP
 * package_Name: a-afsharfarnia/php-mqtt
 * Created_By: Abbas Afsharfarnia (05/09/2020 10:10)
 * Project_Address: https://github.com/a-afsharfarnia/php-mqtt
 */

namespace SampleBundle\Services;

class EmqttManager
{
    private const EMQTT_PUBLIC_TOPIC_STUDENT_DATA = "sample/student/data";

    /** @var EmqttClient */
    private $emqttClient;

    public function __construct(EmqttClient $emqttClient)
    {
        $this->emqttClient = $emqttClient;
    }

    private function publishMessage(string $topic, $message, $qos = 0, $retain = false)
    {
        $this->emqttClient->connect();
        $this->emqttClient->publish($topic, $message, $qos, $retain);
        $this->emqttClient->close();
    }

    /**
     * @param array $data
     */
    public function publishTheNewStudent(array $data): void
    {
        $topic = self::EMQTT_PUBLIC_TOPIC_STUDENT_DATA;
        $this->publishMessage($topic, json_encode($data));
    }
}