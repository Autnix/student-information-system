<?php

namespace SIS\App\Validate;

use SIS\App\Response;
use Valitron\Validator;

class Lessons
{
    public function CreateLesson(array $body, array $params): Response
    {

        $v = new Validator($body);
        $v->rule("required", "lesson_akts")
            ->rule("integer", "lesson_akts")
            ->rule("min", "lesson_akts", 1)
            ->rule("max", "lesson_akts", 10);

        $v->rule("required", "lesson_allow_registration")
            ->rule("integer", "lesson_allow_registration")
            ->rule("in", "lesson_allow_registration", [0, 1]);

        $v->rule("required", "lesson_code");
        $v->rule("required", "lesson_name");

        $v->rule("required", "lesson_mandatory_attendance")
            ->rule("integer", "lesson_mandatory_attendance");

        $v->rule("required", "lesson_total_attendance")
            ->rule("integer", "lesson_mandatory_attendance");

        $v->rule("required", "lesson_semester_id")
            ->rule("integer", "lesson_semester_id");

        if (!$v->validate()) {
            return Response::status(400)->json([
                "error" => true,
                "http-message" => "Bad Request",
                "message" => $v->errors()
            ]);
        }
        return Response::next();

    }

    public function RegisterLesson(array $body, array $params): Response
    {
        $v = new Validator($body);
        $v->rule("required", "lesson_id")->rule("integer", "lesson_id");

        if (!$v->validate()) {
            return Response::status(400)->json([
                "error" => true,
                "http-message" => "Bad Request",
                "message" => $v->errors()
            ]);
        }
        return Response::next();
    }

}