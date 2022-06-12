<?php

use SIS\App\Router;

Router::prefix('/lessons/admin')->group(function () {

    Router::route("/")
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->get("Lessons@GetLessonsOfLecturer");

    Router::route("/create")
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->middleware(\SIS\App\Validator::validate("Lessons@CreateLesson"))
        ->post("Lessons@CreateLesson");

    Router::route("/get/:id")
        ->middleware("Authentication@authenticate")
        ->middleware("Authentication@admin")
        ->get("Lessons@GetOneLessonLecturer");

});

Router::prefix('/lessons')->group(function () {


    Router::route("/get-lessons-register")
        ->middleware("Authentication@authenticate")
        ->get("Lessons@GetLessonsRegister");

    Router::route('/get-lessons-of-student')
        ->middleware("Authentication@authenticate")
        ->get("Lessons@GetLessonsOfStudent");

    Router::route('/get/:id')
        ->middleware("Authentication@authenticate")
        ->get("Lessons@GetOneLesson");

    Router::route('/semesters')
        ->middleware("Authentication@authenticate")
        ->get("Lessons@GetSemesters");

    Router::route("/register")
        ->middleware("Authentication@authenticate")
        ->middleware(\SIS\App\Validator::validate("Lessons@RegisterLesson"))
        ->post("Lessons@RegisterLesson");

});