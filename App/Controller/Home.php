<?php

namespace SIS\App\Controller;

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

        $LogService = $this->service('Logs');

//        return Response::send(Helpers::passwordToHash(""));

//        return Response::send(Helpers::generateAccessToken(['id' => 1, 'name' => 'Atakan', 'studentNumber' => 2018556069]));
        return Response::status(301)->json($LogService->getAll());


    }

    public function mdtest($body, $params)
    {
        return Response::send("Testing middlewares");
    }

    public function NotFound($body, $params)
    {
        return Response::status(404)->json([
            "Error" => true,
            "Message" => "Page Not Found"
        ]);
    }

}