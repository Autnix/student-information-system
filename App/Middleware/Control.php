<?php

namespace SIS\App\Middleware;

use SIS\App\Response;

class Control
{

    public function login($body, $params): Response
    {

        echo "Middleware login running" . PHP_EOL;

        return Response::next();

    }

    public function logout($body, $params): Response
    {

        echo "Middleware logout running" . PHP_EOL;

        return Response::next();

    }

    public function register($body, $params): Response
    {

        echo "Middleware register running" . PHP_EOL;

        return Response::status(500)::send("Internal Server Error");

    }

}