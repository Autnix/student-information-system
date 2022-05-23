<?php

use SIS\App\{Router, Validator, Response};

Router::prefix("/auth")->group(function () {

    Router::route("/login-student")
        ->middleware(Validator::validate("Auth@LoginStudent"))
        ->post("Auth@LoginStudent");

    Router::route("/student/change-password")
        ->middleware("Authentication@authenticate")
        ->middleware(Validator::validate("Auth@ChangePasswordStudents"))
        ->post("Auth@changePasswordStudent");

    Router::route("/login-lecturer")
        ->middleware(Validator::validate("Auth@LoginLecturer"))
        ->post("Auth@LoginLecturer");

    Router::route("/check")
        ->middleware("Authentication@Authenticate")
        ->post(function (array $body, array $params, array $mdData) {

            return Response::status(200)->json($mdData[0]['user']);
        });
});