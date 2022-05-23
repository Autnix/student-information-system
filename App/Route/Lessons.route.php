<?php

use SIS\App\Router;

Router::prefix('/lessons')->group(function () {

    Router::route('/get-lessons-of-student')
        ->middleware("Authentication@Authenticate")
        ->get("Lessons@GetLessonsOfStudent");

    Router::route('/get/:id')
        ->middleware("Authentication@authenticate")
        ->get("Lessons@GetOneLesson");

    Router::route('/semesters')
        ->middleware("Authentication@authenticate")
        ->get("Lessons@GetSemesters");

});