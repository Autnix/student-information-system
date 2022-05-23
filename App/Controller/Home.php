<?php

namespace SIS\App\Controller;

use SIS\App\Config;
use SIS\App\Controller;
use SIS\App\Database;
use SIS\App\Response;
use SIS\App\Service;
use SIS\App\Utils\Helpers;
use SIS\App\Utils\Redirect;

class Home extends Controller
{

    private Service $studentService;

    public function __construct()
    {
        $this->studentService = $this->service("Students");
    }

    public function index($body, $params): Response
    {

        return Response::status(200)->json([
            'API_version' => Config::getenv('API_VERSION'),
            'API_name' => Config::getenv('API_NAME')
        ]);

    }

    public function NotFound($body, $params): Response
    {
        return Response::status(404)->json([
            "Error" => true,
            "Message" => "Page Not Found"
        ]);
    }

    public function GetDetails($body, $params, $mdData): Response
    {

        $details = $this->studentService->getOneByNumberWithDetails($mdData[0]['user']['number']);
        if (!$details) {
            return Response::status(500)->json([
                "error" => true,
                "message" => "Student not found!"
            ]);
        }
        return Response::status(200)->json($details);

    }

}