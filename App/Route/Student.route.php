<?php

use SIS\App\{Router};

Router::prefix("/students")->group(function () {

    Router::route('/')
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->get("Student@GetAll");

    Router::route("/get-by-lesson/:id")
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->get("Student@GetAllByLesson");

    Router::route('/get/:number')
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->get("Student@GetOne");


});