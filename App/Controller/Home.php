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

}