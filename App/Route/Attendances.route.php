<?php

use \SIS\App\Router;

Router::prefix('/attendances')->group(function () {

    Router::route("/get-all-by-lesson/:id")
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->get("Attendances@getAttendancesByLesson");

    Router::route("/save-attendances/:id")
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->middleware(\SIS\App\Validator::validate("Attendances@saveAttendances"))
        ->post("Attendances@saveAttendances");

});