<?php
/**
 * Project_Name: Websocket-MQTT in PHP
 * package_Name: a-afsharfarnia/php-mqtt
 * Created_By: Abbas Afsharfarnia (05/09/2020 10:10)
 * Project_Address: https://github.com/a-afsharfarnia/php-mqtt
 */

namespace SampleBundle\Controller;

use SampleBundle\Services\EmqttManager;
use SampleBundle\Services\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class StudentController extends Controller
{
    /** @var StudentService */
    private $studentService;

    /** @var EmqttManager */
    private $emqttManager;

    /**
     * StudentController constructor.
     *
     * @param StudentService $studentService
     * @param EmqttManager   $emqttManager
     */
    public function __construct(StudentService $studentService, EmqttManager $emqttManager)
    {
        $this->studentService = $studentService;
        $this->emqttManager = $emqttManager;
    }

    /**
     * @Route("/add", methods={"POST"}, name="add-student")
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $data = $request->getContent();
        $data = json_decode($data);
        $name = $data->name;
        $family = $data->family;
        $age = $data->age;

        $studentId = $this->studentService->addNewStudent($name, $family, $age);

        $studentData = [
            'ID' => $studentId,
            'Name' => $name,
            'Family' => $family,
            'Age' => $age
        ];

         $this->emqttManager->publishTheNewStudent($studentData);

        return new JsonResponse($studentData);
    }
}