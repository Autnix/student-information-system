<?php

namespace SIS\App\Controller;

use SIS\App\Controller;
use SIS\App\Database;
use SIS\App\Response;
use SIS\App\Service;
use SIS\App\Utils\Redirect;

class Home extends Controller
{

    public function index($body, $params): Response
    {

        $LogService = $this->service('Logs');

        return Response::status(301)->json($LogService->getAll());

        
    }

    public function mdtest($body, $params)
    {
        return Response::send("Testing middlewares");
    }

}