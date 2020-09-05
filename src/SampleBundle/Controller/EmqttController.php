<?php
/**
 * Project_Name: Websocket-MQTT in PHP
 * package_Name: a-afsharfarnia/php-mqtt
 * Created_By: Abbas Afsharfarnia (05/09/2020 10:10)
 * Project_Address: https://github.com/a-afsharfarnia/php-mqtt
 */

namespace SampleBundle\Controller;

use SampleBundle\Services\EmqttClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EmqttController extends Controller
{
    /** @var EmqttClient */
    private $emqttClient;

    /**
     * EmqttController constructor.
     *
     * @param EmqttClient $emqttClient
     */
    public function __construct(EmqttClient $emqttClient)
    {
        $this->emqttClient = $emqttClient;
    }

    /**
     * @Route("/login",methods={"POST"},name="api_emqtt_login")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        // Variables:
        // - %u: username
        // - %c: clientid
        // - %a: ipaddress
        // - %P: password

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $result = $this->emqttClient->emqttUserAuth($username, $password);

        if ($result) {
            return new JsonResponse([]);
        }

        return new JsonResponse([], 401);
    }

    /**
     * @Route("/acl",methods={"POST"},name="api_emqtt_acl")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function aclAction(Request $request)
    {
        // Variables:
        //  - %A: 1 | 2, 1 = sub, 2 = pub
        //  - %u: username
        //  - %c: clientid
        //  - %a: ipaddress
        //  - %t: topic

        $access = $request->request->get('access');
        $username = $request->request->get('username');
        $topic = $request->request->get('topic');

        $result = $this->emqttClient->emqttAcl($access, $username, $topic);

        if ($result) {
            return new JsonResponse([]);
        }

        return new JsonResponse([], 401);
    }

    /**
     * @Route("/superuser",methods={"POST"},name="api_emqtt_super_user")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function superuserAction(Request $request)
    {
        // Variables:
        // - %u: username
        // - %c: clientid
        // - %a: ipaddress

        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $ip = $request->request->get('ipaddress');

        $result = $this->emqttClient->emqttSuperUserAuth($username, $password, $ip);

        if ($result) {
            return new JsonResponse([]);
        }

        return new JsonResponse([], 401);
    }
}