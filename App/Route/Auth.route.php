<?php

use SIS\App\{Router, Validator, Response};

Router::prefix("/auth")->group(function () {

    Router::route("/login-student")
        ->middleware(Validator::validate("Auth@LoginStudent"))
        ->post("Auth@LoginStudent");

    Router::route("/check")
        ->middleware("Authentication@Authenticate")
        ->post(function (array $body, array $params, array $mdData) {

            return Response::json($mdData[0]['user']);
        });
});