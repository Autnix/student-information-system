<?php

namespace SIS\App\Controller;

use SIS\App\Response;

class Home
{

    public function index($body, $params): Response
    {
        return Response::status(301)->json([
            "username" => "Atakan",
            "age" => 22,
            "studentNumber" => 2018556069
        ]);
    }

    public function users()
    {
        echo "users";
    }

    public function user($body, $params)
    {
        print_r($body);
    }

}