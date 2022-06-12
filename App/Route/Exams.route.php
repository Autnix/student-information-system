<?php

use \SIS\App\Router;

Router::prefix('/exams')->group(function () {

    Router::route("/:id")
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->middleware(\SIS\App\Validator::validate("Exams@saveExams"))
        ->post("Exams@saveExams");

    Router::route("/get-grades/:id")
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->get("Exams@getExamGrades");

    Router::route('/save-grades/:id')
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->middleware(\SIS\App\Validator::validate("Exams@saveGrades"))
        ->post("Exams@saveGrades");

});