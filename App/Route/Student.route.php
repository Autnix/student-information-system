<?php

use SIS\App\{Router};

Router::prefix("/students")->group(function () {

    Router::route('/')->get("Student@GetAll");
    Router::route('/:number')->get("Student@GetOne");

});